<?php

/**
 * @Entity
 * @Table(name="users")
 */
class User
{

    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @Column(type="string")
     */
    protected $hello;

    /**
     * @Column(type="string")
     */
    protected $email;

    /**
     * @Column(type="string")
     */
    protected $login;

    /**
     * @Column(type="string")
     */
    protected $password;

    /**
     * @Column(type="timestrap")
     */
    protected $createdAt;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getHello()
    {
        return $this->hello;
    }

    /**
     * @param mixed $hello
     */
    public function setHello($hello)
    {
        $this->hello = $hello;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

}


// doctrine


$config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(array(__DIR__ . "/src"));

// database configuration parameters
$conn = array(
    'driver'   => 'pdo_mysql',
    'dbname'   => 'test',
    'user'     => 'root',
    'password' => 'root',
    'host'     => 'localhost',
);

// obtaining the entity manager
$entityManager = \Doctrine\ORM\EntityManager::create($conn, $config);

return function ($iterator) use ($entityManager)
{

    global $sql;

    $qb = $entityManager->createQueryBuilder();

    $d = $qb
        ->select('u')//.id', 'u.hello', 'u.email', 'u.login', 'u.password', 'u.createdAt')
        ->from(User::class, 'u')
        ->orWhere($qb->expr()->orX(
            $qb->expr()->eq('u.id', '?0'),
            $qb->expr()->eq('u.id', '?1'),
            $qb->expr()->eq('u.id', '?2'),
            $qb->expr()->eq('u.id', '?3'),
            $qb->expr()->eq('u.id', '?4')
        ))
        ->setParameters([
            $iterator,
            $iterator + 1,
            $iterator + 2,
            $iterator + 3,
            $iterator + 4
        ]);

    $query = $d->getQuery();

    $sql = $query->getSQL();
//    var_dump($query->getSQL());
//    die;

    $query->getArrayResult();

//    var_dump($query->getArrayResult());
//    die;
//        ->execute([
//            $iterator,
//            $iterator + 1,
//            $iterator + 2,
//            $iterator + 3,
//            $iterator + 4,
//        ]);

};