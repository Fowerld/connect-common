<?php

namespace Fei\Service\Connect\Common\Validator;

use Fei\Entity\EntityInterface;
use Fei\Entity\Validator\Exception;
use Fei\Entity\Validator\AbstractValidator;
use Fei\Service\Connect\Common\Entity\Application;
use Fei\Service\Connect\Common\Entity\ApplicationGroup;
use Fei\Service\Connect\Common\Entity\Attribution;
use Fei\Service\Connect\Common\Entity\User;
use Fei\Service\Connect\Common\Entity\UserGroup;

/**
 * Class AttributionValidator
 *
 * @package Fei\Service\Connect\Common\Validator
 */
class AttributionValidator extends AbstractValidator
{
    /**
     * Validate a Message instance
     *
     * @param EntityInterface $entity
     *
     * @return bool
     *
     * @throws Exception
     */
    public function validate(EntityInterface $entity)
    {
        if (!$entity instanceof Attribution) {
            throw new Exception(
                sprintf('The Entity to validate must be an instance of %s', Attribution::class)
            );
        }

        $this->validateSource($entity->getSource());
        $this->validateTarget($entity->getTarget());
        $this->validateRole($entity->getRole());
        $errors = $this->getErrors();

        return empty($errors);
    }

    /**
     * Validate source
     *
     * @param $source
     *
     * @return bool
     * @throws \Fei\Entity\Validator\Exception
     */
    public function validateSource($source)
    {
        if ($source instanceof User) {
            $validator = new UserValidator();
            $response = $validator->validate($source);
        } elseif ($source instanceof UserGroup) {
            $validator = new UserGroupValidator();
            $response = $validator->validate($source);
        } else {
            $this->addError('source', 'Source must be a valid instance of User or UserGroup');
            return false;
        }

        if (!$response) {
            $this->addError('source', 'Source must be a valid instance of User or UserGroup class - ' . $validator->getErrorsAsString());
        }

        return $response;
    }


    /**
     * Validate target
     *
     * @param $target
     *
     * @return bool
     * @throws \Fei\Entity\Validator\Exception
     */
    public function validateTarget($target)
    {
        if ($target instanceof Application) {
            $validator = new ApplicationValidator();
            $response = $validator->validate($target);
        } elseif ($target instanceof ApplicationGroup) {
            $validator = new ApplicationGroupValidator();
            $response = $validator->validate($target);
        } else {
            $this->addError('target', 'Target must be a valid instance of Application or ApplicationGroup');
            return false;
        }

        if (!$response) {
            $this->addError('target', 'Target must be a valid instance of Application or ApplicationGroup class - ' . $validator->getErrorsAsString());
        }

        return $response;
    }


    /**
     * Validate role
     *
     * @param $role
     *
     * @return bool
     * @throws \Fei\Entity\Validator\Exception
     */
    public function validateRole($role)
    {
        $roleValidator = new RoleValidator();
        $response = $roleValidator->validate($role);

        if (!$response) {
            $this->addError('role', 'Role must be a valid instance of Role class - ' . $roleValidator->getErrorsAsString());
        }

        return $response;
    }
}
