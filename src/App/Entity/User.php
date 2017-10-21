<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;


/**
 * Class User
 *
 * @ORM\Table(name="users")
 *
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=255, unique=true)
	 */
	private $email;

	/**
	 * @ORM\Column(type="string", length=255, unique=true)
	 */
	private $username;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $password;

	/**
	 * @ORM\Column(type="array")
	 */
	private $roles = ['ROLE_USER'];

	/**
	 * @ORM\Column(type="boolean")
	 */
	private $enabled;

	/**
	 * @ORM\Column(type="date")
	 */
	private $createdAt;

	/**
	 * @ORM\Column(type="date")
	 */
	private $updatedAt;

	/**
	 * Set roles
	 *
	 * @param array $roles
	 *
	 * @return User
	 */
	public function setRoles($roles = null)
	{
		$this->roles = $roles;

		return $this;
	}

	/**
	 * Get roles
	 *
	 * @return array
	 */
	public function getRoles()
	{
		return !$this->roles ? [] : explode(',', $this->roles);
	}

	/**
	 * @return null
	 */
	public function getSalt()
	{
		return null;
	}

	/**
	 * @return null
	 */
	public function eraseCredentials()
	{
		return $this->password = null;
	}

	/**
	 * Set username
	 *
	 * @param string $username
	 *
	 * @return User
	 */
	public function setUsername($username)
	{
		$this->username = $username;

		return $this;
	}

	/**
	 * Get username
	 *
	 * @return string
	 */
	public function getUsername()
	{
		return $this->username;
	}

	/**
	 * Set password
	 *
	 * @param string $password
	 *
	 * @return User
	 */
	public function setPassword($password)
	{
		$this->password = $password;

		return $this;
	}

	/**
	 * Get password
	 *
	 * @return string
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * Entity fields validation.
	 * @param ClassMetadata $metadata
	 */
	public static function loadValidatorMetadata(ClassMetadata $metadata)
	{
		$metadata->addPropertyConstraint('email', new Assert\NotBlank(['message' => 'fill_in_field']));
		$metadata->addPropertyConstraint('email', new Assert\Email(['message' => 'incorrect_email']));
		$metadata->addPropertyConstraint('username', new Assert\NotBlank(['message' => 'fill_in_field']));
		$metadata->addPropertyConstraint('password', new Assert\NotBlank(['message' => 'fill_in_field']));
		$metadata->addPropertyConstraint('password', new Assert\Length(['max' => '4096', 'maxMessage' => 'input_to_long', 'min' => '5', 'minMessage' => 'input_to_short']));
	}

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return User
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return User
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
