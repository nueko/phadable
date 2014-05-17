<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

class EmployeesMigration_100 extends Migration
{

    public function up()
    {
        $this->morphTable(
            'employees',
            array(
            'columns' => array(
                new Column(
                    'id',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'notNull' => true,
                        'autoIncrement' => true,
                        'size' => 10,
                        'first' => true
                    )
                ),
                new Column(
                    'first_name',
                    array(
                        'type' => Column::TYPE_VARCHAR,
                        'notNull' => true,
                        'size' => 250,
                        'after' => 'id'
                    )
                ),
                new Column(
                    'last_name',
                    array(
                        'type' => Column::TYPE_VARCHAR,
                        'notNull' => true,
                        'size' => 250,
                        'after' => 'first_name'
                    )
                ),
                new Column(
                    'position',
                    array(
                        'type' => Column::TYPE_VARCHAR,
                        'notNull' => true,
                        'size' => 250,
                        'after' => 'last_name'
                    )
                ),
                new Column(
                    'email',
                    array(
                        'type' => Column::TYPE_VARCHAR,
                        'notNull' => true,
                        'size' => 250,
                        'after' => 'position'
                    )
                ),
                new Column(
                    'office',
                    array(
                        'type' => Column::TYPE_VARCHAR,
                        'notNull' => true,
                        'size' => 250,
                        'after' => 'email'
                    )
                ),
                new Column(
                    'start_date',
                    array(
                        'type' => Column::TYPE_DATE,
                        'notNull' => true,
                        'size' => 1,
                        'after' => 'office'
                    )
                ),
                new Column(
                    'age',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'size' => 8,
                        'after' => 'start_date'
                    )
                ),
                new Column(
                    'salary',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'size' => 8,
                        'after' => 'age'
                    )
                ),
                new Column(
                    'extn',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'size' => 8,
                        'after' => 'salary'
                    )
                )
            ),
            'indexes' => array(
                new Index('PRIMARY', array('id'))
            ),
            'options' => array(
                'TABLE_TYPE' => 'BASE TABLE',
                'AUTO_INCREMENT' => '58',
                'ENGINE' => 'InnoDB',
                'TABLE_COLLATION' => 'latin1_swedish_ci'
            )
        )
        );
    }
}
