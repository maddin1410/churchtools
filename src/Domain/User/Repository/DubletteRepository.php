<?php

namespace App\Domain\User\Repository;

use DomainException;
use Selective\Database\Connection;

/**
 * Repository.
 */
final class DubletteRepository
{
    /**
     * @var Connection The database connection
     */
    private Connection $connection;

    /**
     * The constructor.
     *
     * @param Connection $connection The database connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Find double users
     *
     * @param int $userId The user id
     *
     * @return array The user rows
     */
    public function findDubletts(): array
    {
        $return = [];

        // prepare query with needed data to compare persons
        $queryAll = $this->connection->select()->from('cdb_gemeindeperson');
        $queryAll->leftJoin('cdb_person', 'cdb_gemeindeperson.person_id', '=', 'cdb_person.id');
        $queryAll->columns(['cdb_gemeindeperson.id', 'vorname', 'name', 'geburtsdatum']);
        $queryAll->orderBy('name');
        $request = $queryAll->execute();

        // search for doublets
        $doublets = [];
        $tmpPersons = [];
        while ($row = $request->fetch(2))
        {
            $personString = $row['name'] . '_' . $row['vorname'] . '_' . $row['geburtsdatum'];
            if ((array_key_exists($personString, $tmpPersons)))
            {
                if (!array_key_exists($personString, $doublets))
                {
                    $doublets[$personString] = [$row['id'], $tmpPersons[$personString]];
                } else {
                    $doublets[$personString][] = $row['id'];
                }
            } else {
                $tmpPersons[$personString] = $row['id'];
            }
        }

        // fetch all data of founded doublets if exist
        if (!empty($doublets)) {
            $queryDetails = $this->connection->select()->from('cdb_gemeindeperson');
            $queryDetails->columns(['cdb_gemeindeperson.*', 'cdb_person.*', 'pg_id' => 'cdb_gemeindeperson.id', 'p_id' =>'cdb_person.id']);
            $queryDetails->leftJoin('cdb_person', 'cdb_gemeindeperson.person_id', '=', 'cdb_person.id');
            $where = 'where';
            foreach ($doublets as $ids)
            {
                foreach ($ids as $id)
                {
                    $queryDetails->$where('cdb_gemeindeperson.id', '=', $id);
                    $where = 'orWhere';
                }
            }
            $results = $queryDetails->execute()->fetchAll(2);
            foreach ($results as $resultRow)
            {
                $return[$resultRow['p_id']][] = $resultRow;
            }
        }

        return $return;
    }
}
