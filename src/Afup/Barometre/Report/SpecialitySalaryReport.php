<?php

namespace Afup\Barometre\Report;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Report on Speciality Salary
 */
class SpecialitySalaryReport implements ReportInterface
{
    /**
     * @var QueryBuilder
     */
    private $queryBuilder;

    /**
     * {@inheritdoc}
     */
    public function setQueryBuilder(QueryBuilder $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        $this->queryBuilder
            ->join(
                'response',
                'response_speciality',
                'response_speciality',
                'response.id = response_speciality.response_id'
            )
            ->join(
                'response_speciality',
                'speciality',
                'speciality',
                'response_speciality.speciality_id = speciality.id'
            )
            ->select('count(distinct response.id) as nbResponse')
            ->addSelect('response.experience as experience')
            ->addSelect('speciality.name as specialityName')
            ->addSelect('SUM(response.annualSalary) as annualSalary')
            ->addGroupBy('experience, specialityName');

        $results = $this->queryBuilder->execute();

        $framework = [
            'Symfony',
            'Zend Framework',
            'Framework propriétaire'
        ];

        $otherFramework = 'report.view.other_framework';

        $data = [
            'columns' => array_merge($framework, [$otherFramework]),
            'data'    => []
        ];

        foreach ($results as $result) {
            $experience = $result['experience'];
            $specialityName = $result['specialityName'];

            if (!array_key_exists($experience, $data['data'])) {
                $data['data'][$experience] = array_flip($data['columns']);
                $data['data'][$experience][$otherFramework] = ['annualSalary' => 0, 'nbResponse' => 0];
            }

            if (in_array($specialityName, $framework)) {
                $data['data'][$experience][$specialityName] = $result['annualSalary'] / $result['nbResponse'];
            } else {
                $data['data'][$experience][$otherFramework]['annualSalary'] += $result['annualSalary'];
                $data['data'][$experience][$otherFramework]['nbResponse'] += $result['nbResponse'];
            }
        }

        foreach ($data['data'] as $experience => $line) {
            if (0 !== $line[$otherFramework]['nbResponse']) {
                $salary = $line[$otherFramework]['annualSalary'] / $line[$otherFramework]['nbResponse'];
                $data['data'][$experience][$otherFramework] = $salary;
            } else {
                $data['data'][$experience][$otherFramework] = null;
            }
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return "speciality_salary";
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return "report.speciality_salary.label";
    }
}
