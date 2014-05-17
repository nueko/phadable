<?php

use Phalcon\Mvc\Model\Validator\Email as Email;

class Employees extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $first_name;

    /**
     *
     * @var string
     */
    public $last_name;

    /**
     *
     * @var string
     */
    public $position;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var string
     */
    public $office;

    /**
     *
     * @var string
     */
    public $start_date;

    /**
     *
     * @var integer
     */
    public $age;

    /**
     *
     * @var integer
     */
    public $salary;

    /**
     *
     * @var integer
     */
    public $extn;

    /**
     * Validations and business logic
     */
    public function validation()
    {

        $this->validate(
            new Email(
                array(
                    'field'    => 'email',
                    'required' => true,
                )
            )
        );
        if ($this->validationHasFailed() == true) {
            return false;
        }
    }

}
