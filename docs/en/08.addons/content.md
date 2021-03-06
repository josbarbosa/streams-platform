---
title: Addons
---

## Addons[](#addons)

Addons are the primary building blocks of PyroCMS. Logically, Pyro is comprised of and organized as Laravel, the Streams Platform, and any addons.


### The Basics[](#addons/the-basics)

This section will go over the basic behavior of addons in general.


#### Addon Locations[](#addons/the-basics/addon-locations)

This section will go over where addons can be loaded from and the difference between `core` and `application` addons.


##### Core Addons[](#addons/the-basics/addon-locations/core-addons)

All addons listed in the `composer.json` file will be installed by composer in the `/core` directory similar to the `/vendor` directory.

<div class="alert alert-danger">**Heads Up!** Only addons required by the root **composer.json** file will resolve dependencies required by the addon's **composer.json** file.</div>


##### Application Addons[](#addons/the-basics/addon-locations/application-addons)

All non-core addons are considered `application` addons and are located in the `/addons` directory.

<div class="alert alert-info">**Note:** Application addons should be committed to the project's repository.</div>

Application addons are split into `private` addons and `shared` addons.


##### Private Addons[](#addons/the-basics/addon-locations/application-addons/private-addons)

Private addons are located within `/addons/{APP_REF}` directory and are organized by vendor just like the `/core` and `/vendor` directories.

Private addons are only available to the application designated by the `{APP_REF}` directory in which they reside.


##### Shared Addons[](#addons/the-basics/addon-locations/application-addons/shared-addons)

Shared addons are located within `/addons/shared` directory and are organized by vendor just like the `/core` and `/vendor` directories.

Shared addons are available to all applications within the PyroCMS installation.


##### Packaged Addons[](#addons/the-basics/addon-locations/packaged-addons)

Addons can include their own addons. While it is not common the `Grid` and `Repeater` field types are good examples of an addon that come packaged with it's own dependent addons.

Addons can be registered anywhere but when using this technique they are usually found within the `/addons` directory within the addon itself.


#### Addon Object[](#addons/the-basics/addon-object)

All addon types extend the base `Anomaly\Streams\Platform\Addon\Addon` class and inherit some basic functionality.


##### Addon::isCore()[](#addons/the-basics/addon-object/addon-iscore)

The `isCore` method returns whether the addon is `core` or not.

###### Returns: `bool`

###### Example

    if ($addon->isCore()) {
    	echo 'Yep!';
    }

###### Twig

    {% is addon.isCore() %}
    	Yep!
    {% endif %}


##### Addon::isShared()[](#addons/the-basics/addon-object/addon-isshared)

The `isShared` method returns if the addon is `shared` or not.

###### Returns: `bool`

###### Example

    if ($addon->isShared()) {
    	echo 'Yep!';
    }

###### Twig

    {% addon.isShared() %}
    	Yep!
    {% endif %}


##### Addon::getName()[](#addons/the-basics/addon-object/addon-getname)

The `getName` method returns the translatable name of the addon.

###### Returns: `string`

###### Example

    echo trans($addon->getName());

###### Twig

    {{ trans(addon.getName()) }}


##### Addon::getTitle()[](#addons/the-basics/addon-object/addon-gettitle)

The `getTitle` method returns the `title` which generally similar to the `name` but does not include the addon type.

###### Returns: `string`

###### Example

    echo trans($addon->getTitle());

###### Twig

    {{ trans(addon.getTitle()) }}


##### Addon::getDescription()[](#addons/the-basics/addon-object/addon-getdescription)

The `getDescription` method returns the addon description.

###### Returns: `string`

###### Example

    echo trans($addon->getDescription());

###### Twig

    {{ trans(addon.getDescription()) }}


##### Addon::getNamespace()[](#addons/the-basics/addon-object/addon-getnamespace)

The `getNamespace` method returns the addon's `dot namespace` with an optional key.

This is helpful for creating config keys, language keys, hinted view paths, and anything else prefixed by the addon's dot namespace.

###### Returns: `string`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$key

</td>

<td>

false

</td>

<td>

string

</td>

<td>

none

</td>

<td>

The key to append to the namespace.

</td>

</tr>

</tbody>

</table>

###### Example

    $addon->getNamespace(); // anomaly.module.pages
    $addon->getNamespace('config.limit') // anomaly.module.pages::config.limit

###### Twig

    {{ addon.getNamespace() }} // anomaly.module.pages
    {{ addon.getNamespace('config.limit') }} // anomaly.module.pages::config.limit

{{ config(addon.getNamespace('config.limit'), 100) }}


##### Addon::getPath()[](#addons/the-basics/addon-object/addon-getpath)

The `getPath` method returns the addon's installed path.

###### Returns: `string`

###### Example

    require_once $addon->getPath() . '/some/old-timer/file.php'


##### Addon::getAppPath()[](#addons/the-basics/addon-object/addon-getapppath)

The `getAppPath` returns the relative application path of the addon.

###### Returns: `string`

###### Example

    require_once base_path($addon->getPath() . '/some/old-timer/file.php');


##### Addon::getType()[](#addons/the-basics/addon-object/addon-gettype)

The `getType` returns the addon `type` in singular form.

###### Returns: `string`

###### Example

    if ($addon->getType() == 'field_type') {
    	echo "I'm a field type!";
    }

###### Twig

    {% if addon.getType() == "field_type" %}
    	I'm a field type!
    {% endif %}


##### Addon::getSlug()[](#addons/the-basics/addon-object/addon-getslug)

The `getSlug` method returns the slug of the addon.

###### Returns: `string`

###### Example

    echo $addon->getSlug(); // pages

###### Twig

    {{ addon.getSlug() }} // pages


##### Addon::getVendor()[](#addons/the-basics/addon-object/addon-getvendor)

The `getVendor` method returns the vendor string of the addon.

###### Returns: `string`

###### Example

    echo $addon->getVendor(); // anomaly

###### Twig

    {{ addon.getVendor() }} // anomaly


### Field Types[](#addons/field-types)

Field types are responsible for rendering form inputs and managing data transportation in and out of the database and it's models.


#### Displaying Inputs[](#addons/field-types/displaying-inputs)

The main aspect of field types from an end-user perspective is the form inputs they provide. This section will go over how to render inputs and filters for field types.


##### FieldType::render()[](#addons/field-types/displaying-inputs/fieldtype-render)

The `render` method returns the `input` wrapped in a field group wrapper for use in a form. This output method includes the label, required flag, instructions, warning, and the input.

###### Returns: `string`

###### Twig

    {{ field_type.render()|raw }}


##### FieldType::getInput()[](#addons/field-types/displaying-inputs/fieldtype-getinput)

The `getInput` returns the rendered input view used for forms. The view rendered is determined by the field type's `$inputView` property.

This method returns _only_ the input view. No surrounding field group wrapper.

###### Returns: `string`

###### Twig

    {{ field_type.getInput()|raw }}


##### FieldType::getFilter()[](#addons/field-types/displaying-inputs/fieldtype-getfilter)

The `getFilter` method returns the rendered input view for table filtering.

###### Returns: `string`

###### Twig

    {{ field_type.getFilter()|raw }}


#### Presenters[](#addons/field-types/presenters)

Field type presenters decorate the field type and it's contained value. Because objects are automatically decorated on the way to views field type presenters will always be returned for entry values by default.

`{{ entry.attribute }} // The field type presenter::__toString() {{ entry.attribute.value }} // The raw value from the field type presenter`

It is because of this you must using `.value` within `if` statements.


##### FieldType::getPresenter()[](#addons/field-types/presenters/fieldtype-getpresenter)

The `getPresenter` method returns a new presenter instance. By default method uses class transformation to convert `YourFieldType` class to `YourFieldTypePresenter`.

###### Returns: `Anomaly\Streams\Platform\Addon\FieldType\FieldTypePresenter`

###### Example

    $fieldType->getPresenter()->foo();


#### Modifiers[](#addons/field-types/modifiers)

Modifiers are classes that `modify` values for database storage and `restore` them before hydrating the model. By default no modification is done.


##### FieldType::getModifier()[](#addons/field-types/modifiers/fieldtype-getmodifier)

The `getModifier` method returns a new `modifier` instance. By default this method uses class transformation to convert `YourFieldType` to `YourFieldTypeModifier`.

###### Returns: `Anomaly\Streams\Platform\Addon\FieldType\FieldTypeModifier`


##### FieldTypeModifier::modify()[](#addons/field-types/modifiers/fieldtypemodifier-modify)

The `modify` method modifies the `$value` for storage in the database.

###### Returns: `mixed`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$value

</td>

<td>

true

</td>

<td>

mixed

</td>

<td>

The value as provided by the field type setting the attribute

</td>

</tr>

</tbody>

</table>

###### Example

    public function modify($value)
    {
    	return serialize((array)$value);
    }


##### FieldTypeModifier::restore()[](#addons/field-types/modifiers/fieldtypemodifier-restore)

The `restore` method restores the value _from_ the database.

###### Returns: `mixed`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$value

</td>

<td>

true

</td>

<td>

mixed

</td>

<td>

The value from the database.

</td>

</tr>

</tbody>

</table>

###### Example

    public function restore($value)
    {
    	if (!$value) {
    		return [];
    	}

    	if (is_array($value)) {
    		return $value;
    	}

    	return (array)unserialize($value);
    }


#### Accessors[](#addons/field-types/accessors)

Accessors are responsible for setting the value data on the entry model. By default the value is set on the model as an attribute with the same name as the field.

`$entry->{field} = $value;`


##### FieldType::getAccessor()[](#addons/field-types/accessors/fieldtype-getaccessor)

The `getAccessor` method returns a new accessor instance. By default the method uses class transformation to convert `YourFieldType` to `YourFieldTypeAccessor`.

###### Returns: `Anomaly\Streams\Platform\Addon\FieldType\FieldTypeAccessor`


##### FieldTypeAccessor::set()[](#addons/field-types/accessors/fieldtypeaccessor-set)

The `set` method set's the `$value` on the entry.

###### Returns: `void`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$value

</td>

<td>

true

</td>

<td>

mixed

</td>

<td>

The value from the field type modifier.

</td>

</tr>

</tbody>

</table>

###### Example

    public function set($value)
    {
    	$entry = $this->fieldType->getEntry();
    	$attributes = $entry->getAttributes();
    	if (is_numeric($value)) {
    		$attributes[$this->fieldType->getColumnName()] = $value;
    	}
    	if (is_object($value) && $data = $this->toData($value)) {
    		$attributes[$this->fieldType->getField() . '_data'] = json_encode($data);
    	}
    	if (is_array($value) && $data = $this->toData($value)) {
    		$attributes[$this->fieldType->getField() . '_data'] = json_encode($data);
    	}
    	if (is_null($value)) {
    		$attributes[$this->fieldType->getColumnName()]      = $value;
    		$attributes[$this->fieldType->getField() . '_data'] = $value;
    	}
    	$entry->setRawAttributes($attributes);
    }


##### FieldTypeAccessor::get()[](#addons/field-types/accessors/fieldtypeaccessor-get)

The `get` method get's the value off the entry.

###### Returns: `mixed`

###### Example

    public function get()
    {
    	$entry = $this->fieldType->getEntry();

    	$attributes = $entry->getAttributes();

    	return [
    		'image' => array_get($attributes, $this->fieldType->getColumnName()),
    		'data' => array_get($attributes, $this->fieldType->getColumnName() . '_data')
    	];
    }


#### Schema[](#addons/field-types/schema)

Field type `schema` classes help control the schema changes required by the field type.


##### FieldType::getSchema()[](#addons/field-types/schema/fieldtype-getschema)

The `getSchema` method returns a new schema instance. By default this method uses class transformation to convert `YourFieldType` class to `YourFieldTypeSchema`.

###### Returns: `Anomaly\Streams\Platform\Addon\FieldType\FieldTypeSchema`


##### FieldTypeSchema::addColumn()[](#addons/field-types/schema/fieldtypeschema-addcolumn)

The `addColumn` method is responsible for adding the column required by the field type to the database table. By default this is automated and adds a column named after the `field_slug` and uses the column type as defined by the field type.

###### Returns: `void`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Type</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$table

</td>

<td>

\Illuminate\Database\Schema\Blueprint

</td>

<td>

The table blueprint utility.

</td>

</tr>

<tr>

<td>

$assignment

</td>

<td>

\Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface

</td>

<td>

The assignment object representing the assigned field.

</td>

</tr>

</tbody>

</table>


##### FieldTypeSchema::updateColumn()[](#addons/field-types/schema/fieldtypeschema-updatecolumn)

The `updateColumn` updates the columns features as required by the field or assignment changes.

###### Returns: `void`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Type</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$table

</td>

<td>

\Illuminate\Database\Schema\Blueprint

</td>

<td>

The table blueprint utility.

</td>

</tr>

<tr>

<td>

$assignment

</td>

<td>

\Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface

</td>

<td>

The updated assignment object representing the assigned field.

</td>

</tr>

</tbody>

</table>


##### FieldTypeSchema::renameColumn()[](#addons/field-types/schema/fieldtypeschema-renamecolumn)

The `renameColumn` is responsible for renaming the field type column(s) when a field object is updated.

###### Returns: `void`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Type</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$table

</td>

<td>

\Illuminate\Database\Schema\Blueprint

</td>

<td>

The table blueprint utility.

</td>

</tr>

<tr>

<td>

$from

</td>

<td>

\Anomaly\Streams\Platform\Addon\FieldType\FieldType

</td>

<td>

The field type from the updated fields.

</td>

</tr>

<tr>

<td>

INTERNAL $to

</td>

<td>

\Anomaly\Streams\Platform\Addon\FieldType\FieldType

</td>

<td>

The current field type is always available as $this->fieldType

</td>

</tr>

</tbody>

</table>


##### FieldTypeSchema::changeColumn()[](#addons/field-types/schema/fieldtypeschema-changecolumn)

The `changeColumn` method changes the column type as needed when changing the field type for a field.

###### Returns: `void`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Type</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$table

</td>

<td>

\Illuminate\Database\Schema\Blueprint

</td>

<td>

The table blueprint utility.

</td>

</tr>

<tr>

<td>

$assignment

</td>

<td>

\Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface

</td>

<td>

The updated assignment object representing the changed field.

</td>

</tr>

</tbody>

</table>


##### FieldTypeSchema::dropColumn()[](#addons/field-types/schema/fieldtypeschema-dropcolumn)

The `dropColumn` method drops the field type's column from the database table when the assignment is deleted.

###### Returns: `void`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Type</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$table

</td>

<td>

\Illuminate\Database\Schema\Blueprint

</td>

<td>

The table blueprint utility.

</td>

</tr>

</tbody>

</table>


##### FieldTypeSchema::backupColumn()[](#addons/field-types/schema/fieldtypeschema-backupcolumn)

The `backupColumn` method temporarily backs up the column data in cache.

###### Returns: `void`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Type</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$table

</td>

<td>

\Illuminate\Database\Schema\Blueprint

</td>

<td>

The table blueprint utility.

</td>

</tr>

</tbody>

</table>


##### FieldTypeSchema::restoreColumn()[](#addons/field-types/schema/fieldtypeschema-restorecolumn)

The `restoreColumn` restores the backup data from the `backupColumn` method.

###### Returns: `void`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Type</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$table

</td>

<td>

\Illuminate\Database\Schema\Blueprint

</td>

<td>

The table blueprint utility.

</td>

</tr>

</tbody>

</table>


#### Parsers[](#addons/field-types/parsers)

Field type `parsers` allow you to control what is parsed on the compiled entry model when the stream, assignments, or fields are modified. This method will also fire during manual compiling with the `streams:compile` artisan command.


##### FieldType::getParser()[](#addons/field-types/parsers/fieldtype-getparser)

The `getParser` method returns a new parser instance. By default this method uses class transformation to convert `YourFieldType` class to `YourFieldTypeParser`.

###### Returns: `Anomaly\Streams\Platform\Addon\FieldType\FieldTypeParser`


##### FieldTypeParser::relation()[](#addons/field-types/parsers/fieldtypeparser-relation)

The relation method is only ran when the field type provides a `getRelation` method.

###### Returns: `string`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Type</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$assignment

</td>

<td>

\Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface

</td>

<td>

The assignment object representing the assigned field.

</td>

</tr>

</tbody>

</table>


#### Query Builders[](#addons/field-types/query-builders)

The field type `query builders` provide methods for manipulating query builders. These methods are using for filtering field type values and for extending the functionality of the query builder through the field type.


##### FieldTypeQuery::filter()[](#addons/field-types/query-builders/fieldtypequery-filter)

The `filter` method filters a query builder with the value provided by a table filter interface.

###### Returns: `void`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Type</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$query

</td>

<td>

\Illuminate\Database\Eloquent\Builder

</td>

<td>

The query builder for the table entries.

</td>

</tr>

<tr>

<td>

$filter

</td>

<td>

\Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract\FilterInterface

</td>

<td>

The table filter interface.

</td>

</tr>

</tbody>

</table>

</div>
