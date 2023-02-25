<?php

namespace PhpCycleOrm\Lib;

use Cycle\Database\DatabaseManager;
use Cycle\Database\Config;
use Spiral\Tokenizer;
use Cycle\Schema;
use Cycle\Annotated;

class SchemaBuilder
{
    private function getConfig()
    {
        return new Config\DatabaseConfig([
            'databases' => [
                'default' => [
                    'driver' => 'mysql'
                ]
            ],
            'connections' => [
                'mysql' => new Config\MySQLDriverConfig(
                    connection: new Config\MySQL\TcpConnectionConfig(
                        database: 'cycle_orm',
                        host: 'localhost',
                        port: 3306,
                        user: 'root',
                        password: 'test123',
                    ),
                    queryCache: true
                ),
            ],
        ]);
    }

    public function SyncSchema()
    {
        $dbal = new DatabaseManager($this->getConfig());

        // Class locator
        $classLocator = (new Tokenizer\Tokenizer(new Tokenizer\Config\TokenizerConfig([
            'directories' => ['src/Entity'],
        ])))->classLocator();

        $schema = (new Schema\Compiler())->compile(new Schema\Registry($dbal), [
            new Schema\Generator\ResetTables(),             // re-declared table schemas (remove columns)
            new Annotated\Embeddings($classLocator),        // register embeddable entities
            new Annotated\Entities($classLocator),          // register annotated entities
            new Annotated\TableInheritance(),               // register STI/JTI
            new Annotated\MergeColumns(),                   // add @Table column declarations
            new Schema\Generator\GenerateRelations(),       // generate entity relations
            new Schema\Generator\GenerateModifiers(),       // generate changes from schema modifiers
            new Schema\Generator\ValidateEntities(),        // make sure all entity schemas are correct
            new Schema\Generator\RenderTables(),            // declare table schemas
            new Schema\Generator\RenderRelations(),         // declare relation keys and indexes
            new Schema\Generator\RenderModifiers(),         // render all schema modifiers
            new Annotated\MergeIndexes(),                   // add @Table column declarations
            new Schema\Generator\SyncTables(), // sync table changes to database
            new Schema\Generator\GenerateTypecast(),        // typecast non string columns
        ]);

        return $schema;
    }
}
