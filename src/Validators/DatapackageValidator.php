<?php namespace frictionlessdata\datapackage\Validators;

use frictionlessdata\datapackage\Registry;
use frictionlessdata\datapackage\Validators\ResourceValidator;

/**
 * validate a datapackage descriptor
 * checks the profile attribute to determine which schema to validate with
 */
class DatapackageValidator extends BaseValidator
{
    protected function getSchemaValidationErrorClass()
    {
        return "frictionlessdata\\datapackage\\Validators\\DatapackageValidationError";
    }

    protected function getValidationProfile()
    {
        return Registry::getDatapackageValidationProfile($this->descriptor);
    }

    protected function getDescriptorForValidation()
    {
        // add base path to uri fields
        // TODO: find a more elegant way to do it with support for registring custom url fields
        $descriptor = clone $this->descriptor;
        if (isset($descriptor->resources)) {
            foreach ($descriptor->resources as &$resource) {
                $resource = clone $resource;
                foreach ($resource->data as &$url) {
                    $url = "file://".$url;
                }
            }
        }
        return $descriptor;
    }

    protected function validateSchema()
    {
        parent::validateSchema();
        if ($this->getValidationProfile() != "data-package") {
            // all schemas must be an extension of datapackage spec
            $this->validateSchemaUrl(
                $this->convertValidationSchemaFilenameToUrl(
                    $this->getJsonSchemaFileFromRegistry("data-package")
                )
            );
        }
    }

    protected function validateKeys()
    {
        foreach ($this->descriptor->resources as $resourceDescriptor) {
            foreach ($this->resourceValidate($resourceDescriptor) as $error) {
                $this->errors[] = $error;
            }
        }
    }

    protected function resourceValidate($resourceDescriptor)
    {
        return ResourceValidator::validate($resourceDescriptor, $this->basePath);
    }

    protected function getJsonSchemaFileFromRegistry($profile)
    {
        if ($filename = Registry::getJsonSchemaFile($profile)) {
            return $filename;
        } else {
            return parent::getJsonSchemaFileFromRegistry($profile);
        }
    }
}
