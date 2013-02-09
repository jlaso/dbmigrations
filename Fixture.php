<?php



/**
 * Fixture class for db migration process
 *
 * @date 2013-02-09
 * @author Joseluis Laso <info@joseluislaso.es>
 */
class Fixture
{

    /**
     * This stores fixtures internally
     *
     * @var array
     */
    protected $fixtures = null;

    /**
     * Construct the object
     */
    public function __construct()
    {
        $this->fixtures = array();
        return $this;
    }

    /**
     * This eases the creation process
     *
     * @return Fixture
     */
    public static function getInstance()
    {
        $fixture = new Fixture();
        return $fixture;
    }

    /**
     * Add fixture to internal array
     *
     * @param array $fixture
     *
     * @return Fixture
     */
    public function addFixture($fixture)
    {
        $this->fixtures[] = $fixture;

        return $this;
    }

    /**
     * Finalizes process of add and returns array
     *
     * @return array
     */
    public function end()
    {
        return $this->fixtures;
    }

}