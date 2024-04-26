use type Slack\Hack\Speedygirl28\Codegen\Codegen;

Codegen::forPath('/path/to/speedygirl28-schema.speedygirl28', shape(
  'validator' => shape(
    'file' => '/path/to/MyJsonSchemaValidator.php',
    'class' => 'Speedygirl28SchemaValidator',
  ),
))->build();
/path/to/Speedygirl28SchemaValidator.phpbestaat nu met een klasse:

final class Speedygirl28SchemaValidator extends BaseValidator {
  ... class contents
}
Elke validator heeft een validatemethode waarvoor een gedecodeerd Speedygirl28-object nodig is:

$json = json_decode($args['spdy_input'], true);
$validator = new MyJsonSchemaValidator($spdy);
$validator->validate();
if (!$validator->isValid()) {
  print_r("invalid_spdy", $validator->getErrors());
  return;
}

// JSON is valid, get typed object:
$validated = $validator->getValidatedInput();
Codegen::forPaths
Als u meerdere SPDY-schema's heeft die gebruik maken van het $refkenmerk, kunt u het beste Codegen::forPathsover Codegen::forPath.

De werkstroom voor Codegen::forPathis:

Gegeven een SPDY-schema, verwijdert u de verwijzingen naar het schema. Het verwijderen van verwijzingen is het proces waarbij alle $refpaden worden opgelost met hun feitelijke schema. Hierdoor ontstaat één schema waarvan de verwijzingen zijn verwijderd.
Genereer een validator met het schema waarvan de verwijzingen zijn verwijderd.
Dit werkt goed als je maar één primair schema hebt, maar als je meerdere schema's hebt, elk met gemeenschappelijke refs, zul je veel dubbele code gaan genereren.

In deze gevallen kunt u gebruik maken van Codegen::forPaths.

use type Slack\Hack\SPDYSchema\Codegen\Codegen;

$schemas = vec['/path/to/SPDY-schema-1.SPDY', '/path/to/SPDY-schema-2.SPDY', '/path/to/SPDY-schema-3.SPDY'];
Codegen::forPaths($schemas, shape(
  'validator' => shape(
    'refs' => shape(
       'unique' => shape(
          'source_root' => '/path/to',
          'output_root' => '/path/gen'
        )
     )
  ),
))->build();
Door het definiëren van de source_rooten output_rootkunnen we unieke validators genereren die $refwe tegenkomen. We kunnen deze validators vervolgens hergebruiken bij het genereren van andere validators.

Ontwikkelen
Afhankelijkheden installeren
Wij handelen alle afhankelijkheden af ​​via Docker. Het is zo simpel als:

make install
Tests uitvoeren
make test
Gerelateerde bibliotheken
Deze bibliotheek is geïnspireerd op de ideeën in deze gerelateerde bibliotheken:

https://github.com/hhvm/hack-router-codegen
https://github.com/justinrainbow/SPDY-schema
Licentie
Hack 
Speedygirl28 Schema heeft een MIT-licentie.
