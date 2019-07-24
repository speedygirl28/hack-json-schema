<?hh // strict

namespace Slack\Hack\JsonSchema\Codegen;

use type \Facebook\HackCodegen\{
  CodegenShape,
  CodegenProperty,
  CodegenMethod,
  HackBuilderValues,
};

type TNumberSchema = shape(
  'type' => TSchemaType,
  ?'maximum' => int,
  ?'minimum' => int,
  ?'coerce' => bool,
  ...
);

class NumberBuilder extends BaseBuilder<TNumberSchema> {
  protected static string $schema_name =
    'Slack\Hack\JsonSchema\Codegen\TNumberSchema';

  public function build(): this {
    $class = $this->codegenClass()
      ->addMethod($this->getCheckMethod());

    $properties = [];
    $maximum = $this->typed_schema['maximum'] ?? null;
    if ($maximum is nonnull) {
      $properties[] = $this->codegenProperty('maximum')
        ->setType('int')
        ->setValue($maximum, HackBuilderValues::export());
    }

    $minimum = $this->typed_schema['minimum'] ?? null;
    if ($minimum is nonnull) {
      $properties[] = $this->codegenProperty('minimum')
        ->setType('int')
        ->setValue($minimum, HackBuilderValues::export());
    }

    $enum = $this->getEnumCodegenProperty();
    if ($enum is nonnull) {
      $properties[] = $enum;
    }

    $coerce = $this->typed_schema['coerce'] ?? $this->ctx->getCoerceDefault();
    $properties[] = $this->codegenProperty('coerce')
      ->setType('bool')
      ->setValue($coerce, HackBuilderValues::export());

    $class->addProperties($properties);
    $this->addBuilderClass($class);

    return $this;
  }

  protected function getCheckMethod(): CodegenMethod {
    $hb = $this->getHackBuilder();

    if ($this->typed_schema['type'] === TSchemaType::INTEGER_T) {
      $type_constraint = 'Constraints\IntegerConstraint';
      $return_type = 'int';
    } else {
      $type_constraint = 'Constraints\NumberConstraint';
      $return_type = 'num';
    }

    $hb
      ->addAssignment(
        '$typed',
        "{$type_constraint}::check(\$input, \$pointer, self::\$coerce)",
        HackBuilderValues::literal(),
      )
      ->ensureEmptyLine();

    $this->addEnumConstraintCheck($hb);

    if (($this->typed_schema['maximum'] ?? null) is nonnull) {
      $hb->addMultilineCall(
        'Constraints\NumberMaximumConstraint::check',
        ['$typed', 'self::$maximum', '$pointer'],
      );
    }

    if (($this->typed_schema['minimum'] ?? null) is nonnull) {
      $hb->addMultilineCall(
        'Constraints\NumberMinimumConstraint::check',
        ['$typed', 'self::$minimum', '$pointer'],
      );
    }

    $hb->addReturn('$typed', HackBuilderValues::literal());

    return $this->codegenCheckMethod()
      ->addParameters(['mixed $input', 'string $pointer'])
      ->setBody($hb->getCode())
      ->setReturnType($return_type);
  }

  public function getType(): string {
    if ($this->typed_schema['type'] === TSchemaType::INTEGER_T)
      return 'int';
    return 'num';
  }

}