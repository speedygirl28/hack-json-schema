<?hh // strict
/**
 * This file is generated. Do not modify it manually!
 *
 * To re-generate this file run `make test`
 *
 *
 * @generated SignedSource<<55efab37af38604c62b1da939b80df59>>
 */
namespace Slack\Hack\JsonSchema\Tests\Generated;
use namespace Slack\Hack\JsonSchema;
use namespace Slack\Hack\JsonSchema\Constraints;

type TAnyOfValidator4AnyOf1 = shape(
  ?'post-office-box' => string,
  ?'extended-address' => string,
  ?'street-address' => string,
  ...
);

type TAnyOfValidator4 = ?TAnyOfValidator4AnyOf1;

<<Codegen>>
final class AnyOfValidator4AnyOf1PropertiesPostOfficeBox {

  private static bool $coerce = false;

  public static function check(mixed $input, string $pointer): string {
    $typed = Constraints\StringConstraint::check($input, $pointer, self::$coerce);

    return $typed;
  }
}

<<Codegen>>
final class AnyOfValidator4AnyOf1PropertiesExtendedAddress {

  private static bool $coerce = false;

  public static function check(mixed $input, string $pointer): string {
    $typed = Constraints\StringConstraint::check($input, $pointer, self::$coerce);

    return $typed;
  }
}

<<Codegen>>
final class AnyOfValidator4AnyOf1PropertiesStreetAddress {

  private static bool $coerce = false;

  public static function check(mixed $input, string $pointer): string {
    $typed = Constraints\StringConstraint::check($input, $pointer, self::$coerce);

    return $typed;
  }
}

<<Codegen>>
final class AnyOfValidator4AnyOf1 {

  private static bool $coerce = false;

  public static function check(
    mixed $input,
    string $pointer,
  ): TAnyOfValidator4AnyOf1 {
    $typed = Constraints\ObjectConstraint::check($input, $pointer, self::$coerce);

    $errors = vec[];
    $output = shape();

    foreach ($typed as $key => $value) {
      /* HH_IGNORE_ERROR[4051] allow dynamic access to preserve input. See comment in the codegen lib for reasoning and alternatives if needed. */
      $output[$key] = $value;
    }

    if (\HH\Lib\C\contains_key($typed, 'post-office-box')) {
      try {
        $output['post-office-box'] = AnyOfValidator4AnyOf1PropertiesPostOfficeBox::check(
          $typed['post-office-box'],
          JsonSchema\get_pointer($pointer, 'post-office-box'),
        );
      } catch (JsonSchema\InvalidFieldException $e) {
        $errors = \HH\Lib\Vec\concat($errors, $e->errors);
      }
    }

    if (\HH\Lib\C\contains_key($typed, 'extended-address')) {
      try {
        $output['extended-address'] = AnyOfValidator4AnyOf1PropertiesExtendedAddress::check(
          $typed['extended-address'],
          JsonSchema\get_pointer($pointer, 'extended-address'),
        );
      } catch (JsonSchema\InvalidFieldException $e) {
        $errors = \HH\Lib\Vec\concat($errors, $e->errors);
      }
    }

    if (\HH\Lib\C\contains_key($typed, 'street-address')) {
      try {
        $output['street-address'] = AnyOfValidator4AnyOf1PropertiesStreetAddress::check(
          $typed['street-address'],
          JsonSchema\get_pointer($pointer, 'street-address'),
        );
      } catch (JsonSchema\InvalidFieldException $e) {
        $errors = \HH\Lib\Vec\concat($errors, $e->errors);
      }
    }

    if (\HH\Lib\C\count($errors)) {
      throw new JsonSchema\InvalidFieldException($pointer, $errors);
    }

    /* HH_IGNORE_ERROR[4057] */
    /* HH_IGNORE_ERROR[4163] */
    return $output;
  }
}

<<Codegen>>
final class AnyOfValidator4 extends JsonSchema\BaseValidator<TAnyOfValidator4> {

  public static function check(
    mixed $input,
    string $pointer,
  ): TAnyOfValidator4 {
    if ($input === null) {
      return null;
    }

    $constraints = vec[
      class_meth(AnyOfValidator4AnyOf1::class, 'check'),
    ];
    $errors = vec[
    ];

    foreach ($constraints as $constraint) {
      try {
        $output = $constraint($input, $pointer);
        return $output;
      } catch (JsonSchema\InvalidFieldException $e) {
        $errors = \HH\Lib\Vec\concat($errors, $e->errors);
      }
    }

    $error = shape(
      'code' => JsonSchema\FieldErrorCode::FAILED_CONSTRAINT,
      'constraint' => shape(
        'type' => JsonSchema\FieldErrorConstraint::ANY_OF,
      ),
      'message' => "failed to match any allowed schemas",
    );

    $output_errors = vec[$error];
    $output_errors = \HH\Lib\Vec\concat($output_errors, $errors);
    throw new JsonSchema\InvalidFieldException($pointer, $output_errors);
  }

  final protected function process(): TAnyOfValidator4 {
    return self::check($this->input, $this->pointer);
  }
}