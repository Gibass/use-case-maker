# UseCase Maker
The UseCase Maker help you to generate folder structure for hexagonal architecture project on symfony Project.

## Folder Structure
For example we need to create a Blog domain with Create as a UseCase, whit this bundle we can generate a folder structure 
like this :
```scala
|-- Domain // A folder which contains all code Base for project
|   `-- Blog // A Specific domain
|       |-- Presenter
|       |   |-- CreatePresenterInteface.php
|       |-- Request
|       |   |-- CreateRequest.php
|       |-- Response
|       |   |-- CreateResponse.php
|       |-- UseCase
|       |   |-- Create.php
```

#### Test Folder
The bundle generate a Test Class for the useCase
```scala
|-- tests // A default test Forlder
|   `-- Unit
|       |-- CreateTest.php
```

## Installation
1. Installing the bundle with composer :
```shell
composer require --dev gibass/use-case-maker 
```

2. Add this line in `config/bundles.php`:
```php
Gibass\UseCaseMakerBundle\UseCaseMakerBundle::class => ['dev' => true, 'test' => true],
```

## Configuration
You can choose your specific main folder to create a Domain structure on override the default configuration.
Create a file `use_case_maker.yaml` under `config/packages` folder and paste this configuration:

```yaml
use_case_maker:
    parameters:
        root_namespace: App
        dir:
            domain: '%kernel.project_dir%/src/Domain'
            test: '%kernel.project_dir%/tests/Unit'
        namespace_prefix:
            domain: App\Domain
            test: App\Tests\Unit
```

You can change value as you want

## Command
You can run command like this
```shell
php bin/console maker:user-case
```