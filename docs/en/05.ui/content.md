---
title: UI
---

## UI[](#ui)

The Streams Platform comes with a number of UI `builders` that help you manipulate the `user interface`. Working with and writing builders will incorporate know-how from this entire documentation and then some. Let's dig in!


### Breadcrumbs[](#ui/breadcrumbs)

Breadcrumbs in general are automated. However they can be modified, disabled, and managed manually too.


#### Basic Usage[](#ui/breadcrumbs/basic-usage)

To add manage breadcrumbs for your own module you must first include the `\Anomaly\Streams\Platform\Ui\Breadcrumb\BreadcrumbCollection` class.


##### BreadcrumbCollection::add()[](#ui/breadcrumbs/basic-usage/breadcrumbcollection-add)

The `add` method adds a breadcrumb to the end of the collection.

###### Returns: `\Anomaly\Streams\Platform\Ui\Breadcrumb\BreadcrumbCollection`

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

true

</td>

<td>

string

</td>

<td>

none

</td>

<td>

The breadcrumb key name. Translation keys are supported.

</td>

</tr>

<tr>

<td>

$url

</td>

<td>

true

</td>

<td>

string

</td>

<td>

none

</td>

<td>

The URL or path for the breadcrumb.

</td>

</tr>

</tbody>

</table>

###### Example

    $breadcrumbs->add('anomaly.module.products::breadcrumb.products', '/products');

<div class="alert alert-info">**Note:** Breadcrumbs are available as a property in controllers by default.</div>

    <?php namespace Anomaly\ProductsModule\Http\Controller;

    use Anomaly\ProductsModule\Category\Contract\CategoryRepositoryInterface;
    use Anomaly\Streams\Platform\Http\Controller\PublicController;

    class CategoriesController extends PublicController
    {

        /**
         * View products within a category.
         *
         * @param CategoryRepositoryInterface $categories
         * @return \Illuminate\Contracts\View\View
         */
        public function view(CategoryRepositoryInterface $categories)
        {
            $category = $categories->findByPath($this->route->getParameter('path'));

            $this->breadcrumbs->add(
                'module::breadcrumb.products',
                $url->route('anomaly.module.products::products.index')
            );

            $this->breadcrumbs->add($category->getName(), $this->url->make('anomaly.module.products::category', $category));

            return $this->view->make('anomaly.module.products::categories/view');
        }
    }


##### Displaying Breadcrumbs[](#ui/breadcrumbs/basic-usage/displaying-breadcrumbs)

The breadcrumb collection is loaded into the `template` super variable letting you display breadcrumbs as needed.

    <ol class="breadcrumb">
        {% for key, url in template.breadcrumbs %}

            {% if loop.last %}
                <li class="active">{{ trans(key) }}</li>
            {% else %}
                <li><a href="{{ url }}">{{ trans(key) }}</a></li>
            {% endif %}

        {% endfor %}
    </ol>


### Buttons[](#ui/buttons)

Button `definitions` are used often in other UI definitions. For example module sections can define buttons and form actions extend them.

Understanding the anatomy and general behavior of button definitions is integral in working proficiently with UI builders.


#### Introduction[](#ui/buttons/introduction)

This section will introduce you to buttons and how to define them.


##### Defining Buttons[](#ui/buttons/introduction/defining-buttons)

Buttons are defined by simple arrays. These buttons are ran through various processing and is used to `hydrate` instances of the `\Anomaly\Streams\Platform\Ui\Button\Button` class for use by the Streams Platform.

The idea behind defining buttons is that you can provide minimal information about a button and the Streams Platform can do the rest for you. Saving you from having to define the instance yourself with all required parameters.

Button definitions are simply an array:

    'buttons' => [
        'create'          => [
            'url' => '/admin/example/test/create',
            'text' => 'streams::button.create',
            'icon' => 'fa asterisk',
            'type' => 'success',
        ],
    ]


#### The Button Definition[](#ui/buttons/the-button-definition)

Button definitions are ran through `valuation`, `evaluation`, and `resolving`, as well as other processes like guessing. These are the simple property descriptions for buttons.

###### Properties

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

$url

</td>

<td>

false

</td>

<td>

string

</td>

<td>

{section.path}/{button.slug}/{entry.id}

</td>

<td>

The HREF attribute of the button.

</td>

</tr>

<tr>

<td>

$button

</td>

<td>

false

</td>

<td>

string

</td>

<td>

Anomaly\Streams\Platform\Ui\Button

</td>

<td>

The target button class to build.

</td>

</tr>

<tr>

<td>

$text

</td>

<td>

false

</td>

<td>

string

</td>

<td>

{vendor}.module.{module}::button.{button}.title

</td>

<td>

The button text.

</td>

</tr>

<tr>

<td>

$icon

</td>

<td>

false

</td>

<td>

string

</td>

<td>

null

</td>

<td>

A registered icon string or icon class.

</td>

</tr>

<tr>

<td>

$class

</td>

<td>

false

</td>

<td>

string

</td>

<td>

null

</td>

<td>

The CSS class to append ot the button class attribute.

</td>

</tr>

<tr>

<td>

$type

</td>

<td>

false

</td>

<td>

string

</td>

<td>

default

</td>

<td>

The button type or context. Bootstrap state colors (primary, success, etc) are supported by default.

</td>

</tr>

<tr>

<td>

$size

</td>

<td>

false

</td>

<td>

string

</td>

<td>

md

</td>

<td>

The button size. Bootstrap button sized are supported by default.

</td>

</tr>

<tr>

<td>

$attributes

</td>

<td>

false

</td>

<td>

string

</td>

<td>

null

</td>

<td>

An array of `key => value` HTML attributes. Any base level definition keys starting with `data-` will be pushed into attributes automatically.

</td>

</tr>

<tr>

<td>

$permission

</td>

<td>

false

</td>

<td>

string

</td>

<td>

null

</td>

<td>

The permission key required to display the button.

</td>

</tr>

<tr>

<td>

$disabled

</td>

<td>

false

</td>

<td>

boolean

</td>

<td>

false

</td>

<td>

Determines whether the button will be disabled or not.

</td>

</tr>

<tr>

<td>

$enabled

</td>

<td>

false

</td>

<td>

boolean

</td>

<td>

true

</td>

<td>

Determines whether the button will be rendered or not.

</td>

</tr>

<tr>

<td>

$dropdown

</td>

<td>

false

</td>

<td>

array

</td>

<td>

null

</td>

<td>

An array of item definitions. See below for more information.

</td>

</tr>

<tr>

<td>

$position

</td>

<td>

false

</td>

<td>

string

</td>

<td>

left

</td>

<td>

The position of the button's dropdown.

</td>

</tr>

</tbody>

</table>


##### ButtonRegistry::register()[](#ui/buttons/the-button-definition/buttonregistry-register)

The `register` method adds a globally available button definition.

###### Returns: `Anomaly\Streams\Platform\Ui\Button\ButtonRegistry`

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

$button

</td>

<td>

true

</td>

<td>

string

</td>

<td>

none

</td>

<td>

The button key.

</td>

</tr>

<tr>

<td>

$parameters

</td>

<td>

true

</td>

<td>

array

</td>

<td>

none

</td>

<td>

The registered button parameters.

</td>

</tr>

</tbody>

</table>

###### Example

    $registery->register(
        'purchase', 
        [
            'type' => 'success',
            'text' => 'Purchase',
            'icon' => 'fa fa-credit-card',
            'href' => 'checkout/{entry.id}',
        ]
    );


#### The Dropdown Definition[](#ui/buttons/the-dropdown-definition)

The button `dropdown` property can be used to define a dropdown menu for the button.

    'buttons' => [
        'save' => [
            'dropdown' => [
                [
                    'icon' => 'save',
                    'text' => 'Save and exit',
                ],
                [
                    'icon' => 'fa fa-sign-out',
                    'text' => 'Save and continue',
                ]
            ]
        ]
    ]

###### Properties

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

$text

</td>

<td>

true

</td>

<td>

string

</td>

<td>

null

</td>

<td>

The text or translation key.

</td>

</tr>

<tr>

<td>

$icon

</td>

<td>

false

</td>

<td>

string

</td>

<td>

null

</td>

<td>

A registered icon string or icon class.

</td>

</tr>

<tr>

<td>

$url

</td>

<td>

true

</td>

<td>

string

</td>

<td>

null

</td>

<td>

The button URL. This gets pushed into `attributes` automatically as HREF.

</td>

</tr>

</tbody>

</table>


#### The Button Registry[](#ui/buttons/the-button-registry)

Below are the basic registered buttons. Some definitions like form actions that extend buttons may add to these or use them in their own `registry`. In such cases they will be documented separately.

Registered buttons can be found in `Anomaly\Streams\Platform\Ui\Button\ButtonRegistry`.

    /**
     * Default Buttons
     */
    'default'       => [
        'type' => 'default'
    ],
    'cancel'        => [
        'text' => 'streams::button.cancel',
        'type' => 'default'
    ],

    /**
     * Primary Buttons
     */
    'options'       => [
        'text' => 'streams::button.options',
        'type' => 'primary',
        'icon' => 'cog',
    ],

    /**
     * Success Buttons
     */
    'green'         => [
        'type' => 'success'
    ],
    'success'       => [
        'icon' => 'check',
        'type' => 'success'
    ],
    'save'          => [
        'text' => 'streams::button.save',
        'icon' => 'save',
        'type' => 'success'
    ],
    'update'        => [
        'text' => 'streams::button.save',
        'icon' => 'save',
        'type' => 'success'
    ],
    'create'        => [
        'text' => 'streams::button.create',
        'icon' => 'fa fa-asterisk',
        'type' => 'success'
    ],
    'new'           => [
        'text' => 'streams::button.new',
        'icon' => 'fa fa-plus',
        'type' => 'success'
    ],
    'new_field'     => [
        'text' => 'streams::button.new_field',
        'icon' => 'fa fa-plus',
        'type' => 'success'
    ],
    'add'           => [
        'text' => 'streams::button.add',
        'icon' => 'fa fa-plus',
        'type' => 'success'
    ],
    'add_field'     => [
        'text' => 'streams::button.add_field',
        'icon' => 'fa fa-plus',
        'type' => 'success'
    ],
    'assign_fields' => [
        'text' => 'streams::button.assign_fields',
        'icon' => 'fa fa-plus',
        'type' => 'success'
    ],
    'send'          => [
        'text' => 'streams::button.send',
        'icon' => 'envelope',
        'type' => 'success'
    ],
    'submit'        => [
        'text' => 'streams::button.submit',
        'type' => 'success'
    ],
    'install'       => [
        'text' => 'streams::button.install',
        'icon' => 'download',
        'type' => 'success'
    ],
    'entries'       => [
        'text' => 'streams::button.entries',
        'icon' => 'list-ol',
        'type' => 'success'
    ],
    'done'          => [
        'text' => 'streams::button.done',
        'type' => 'success',
        'icon' => 'check'
    ],
    'select'        => [
        'text' => 'streams::button.select',
        'type' => 'success',
        'icon' => 'check'
    ],
    'restore'       => [
        'text' => 'streams::button.restore',
        'type' => 'success',
        'icon' => 'repeat'
    ],
    'finish'        => [
        'text' => 'streams::button.finish',
        'type' => 'success',
        'icon' => 'check'
    ],
    'finished'      => [
        'text' => 'streams::button.finished',
        'type' => 'success',
        'icon' => 'check'
    ],

    /**
     * Info Buttons
     */
    'blue'          => [
        'type' => 'info'
    ],
    'info'          => [
        'type' => 'info'
    ],
    'information'   => [
        'text' => 'streams::button.info',
        'icon' => 'fa fa-info',
        'type' => 'info'
    ],
    'help'          => [
        'icon'        => 'circle-question-mark',
        'text'        => 'streams::button.help',
        'type'        => 'info',
        'data-toggle' => 'modal',
        'data-target' => '#modal'
    ],
    'view'          => [
        'text' => 'streams::button.view',
        'icon' => 'fa fa-eye',
        'type' => 'info'
    ],
    'export'        => [
        'text' => 'streams::button.export',
        'icon' => 'download',
        'type' => 'info'
    ],
    'fields'        => [
        'text' => 'streams::button.fields',
        'icon' => 'list-alt',
        'type' => 'info'
    ],
    'assignments'   => [
        'text' => 'streams::button.assignments',
        'icon' => 'list-alt',
        'type' => 'info'
    ],
    'settings'      => [
        'text' => 'streams::button.settings',
        'type' => 'info',
        'icon' => 'cog',
    ],
    'configure'     => [
        'text' => 'streams::button.configure',
        'icon' => 'wrench',
        'type' => 'info'
    ],

    /**
     * Warning Buttons
     */
    'orange'        => [
        'type' => 'warning'
    ],
    'warning'       => [
        'icon' => 'warning',
        'type' => 'warning'
    ],
    'edit'          => [
        'text' => 'streams::button.edit',
        'icon' => 'pencil',
        'type' => 'warning'
    ],

    /**
     * Danger Buttons
     */
    'red'           => [
        'type' => 'danger'
    ],
    'danger'        => [
        'icon' => 'fa fa-exclamation-circle',
        'type' => 'danger'
    ],
    'remove'        => [
        'text' => 'streams::button.remove',
        'type' => 'danger',
        'icon' => 'ban'
    ],
    'delete'        => [
        'icon'       => 'trash',
        'type'       => 'danger',
        'text'       => 'streams::button.delete',
        'attributes' => [
            'data-toggle'  => 'confirm',
            'data-message' => 'streams::message.confirm_delete'
        ]
    ],
    'prompt'        => [
        'icon'       => 'trash',
        'type'       => 'danger',
        'button'     => 'delete',
        'text'       => 'streams::button.delete',
        'attributes' => [
            'data-match'   => 'yes',
            'data-toggle'  => 'prompt',
            'data-message' => 'streams::message.prompt_delete'
        ]
    ],
    'uninstall'     => [
        'type'       => 'danger',
        'icon'       => 'times-circle',
        'text'       => 'streams::button.uninstall',
        'attributes' => [
            'data-toggle'  => 'confirm',
            'data-message' => 'streams::message.confirm_uninstall'
        ]
    ]


#### Using Registered Buttons[](#ui/buttons/using-registered-buttons)

There are a number of buttons registered in the `\Anomaly\Streams\Platform\Ui\Button\ButtonRegistry` class. To use any of these buttons simply include their string slug and the button's registered definitions will be merged into your own.

    'buttons' => [
        'save',
        'delete' => [
            'text' => 'Delete me!', // Overrides the default "Delete" text.
        ],
    ]

The above `save` and `delete` buttons are registered as:

    'buttons' => [
        'save' => [
            'icon' => 'save',
            'type' => 'success',
            'text' => 'streams::button.save',
        ],
        'delete'        => [
            'icon' => 'trash',
            'type' => 'danger',
            'text' => 'streams::button.delete',
            'attributes' => [
                'data-toggle' => 'confirm',
                'data-message' => 'streams::message.confirm_delete'
            ]
        ],
    ]

Note that the delete text will be overridden since you defined your own text.


### Control Panel[](#ui/control-panel)

The `control panel` defines the upper most admin UI structure. Every page's `control panel` you view in the admin is defined by a `module`.

    <?php namespace Anomaly\ProductsModule;

    use Anomaly\Streams\Platform\Addon\Module\Module;

    class ProductsModule extends Module
    {

        /**
         * The module sections.
         *
         * @var array
         */
        protected $sections = [
            'products'   => [
                'buttons'  => [
                    'new_product' => [
                        'data-toggle' => 'modal',
                        'data-target' => '#modal',
                        'href'        => 'admin/products/choose',
                    ],
                ],
                'sections' => [
                    'attributes' => [
                        'href'    => 'admin/products/attributes/{request.route.parameters.product}',
                        'buttons' => [
                            'add_attribute',
                        ],
                    ],
                    'modifiers'  => [
                        'href'    => 'admin/products/modifiers/{request.route.parameters.product}',
                        'buttons' => [
                            'add_modifier',
                        ],
                    ],
                    'options'    => [
                        'href'    => 'admin/products/options/{request.route.parameters.modifier}',
                        'buttons' => [
                            'add_option',
                        ],
                    ],
                    'variants'   => [
                        'href'    => 'admin/products/variants/{request.route.parameters.product}',
                        'buttons' => [
                            'new_variant',
                        ],
                    ],
                ],
            ],
            'categories' => [
                'buttons' => [
                    'new_category',
                ],
            ],
            'types'      => [
                'buttons'  => [
                    'new_type' => [
                        'data-toggle' => 'modal',
                        'data-target' => '#modal',
                        'href'        => 'admin/products/types/choose',
                    ],
                ],
                'sections' => [
                    'assignments' => [
                        'href'    => 'admin/products/types/assignments/{request.route.parameters.type}',
                        'buttons' => [
                            'assign_fields' => [
                                'data-toggle' => 'modal',
                                'data-target' => '#modal',
                                'href'        => 'admin/products/types/assignments/{request.route.parameters.type}/choose',
                            ],
                        ],
                    ],
                ],
            ],
            'fields'     => [
                'buttons' => [
                    'new_field' => [
                        'data-toggle' => 'modal',
                        'data-target' => '#modal',
                        'href'        => 'admin/products/fields/choose',
                    ],
                ],
            ],
        ];

    }


#### Introduction[](#ui/control-panel/introduction)

This section will introduce you to the `control panel` components and how to use them.


##### Sections[](#ui/control-panel/introduction/sections)

The control panel `sections` are the building blocks for a module's UI.


##### The Module Segment[](#ui/control-panel/introduction/sections/the-module-segment)

Modules are the primary building block of the control panel and must be routed by their slug first.

    admin/products // Products module
    admin/settings // Settings module


##### The Section Segment[](#ui/control-panel/introduction/sections/the-section-segment)

The third slug is reserved for `sections`. Each module is divided into sections. The first section, known as the `default section` does not require a URI segment.

    admin/products              // default section of products module
    admin/products/categories   // "categories" section of products module
    admin/products/brands       // "brands" section of products module

<div class="alert alert-info">**Pro-tip:** An excellent naming convention is to name your products after your primary stream. And your default section after your module and primary stream as well so everything aligns nicely.</div>


##### Additional Segments[](#ui/control-panel/introduction/sections/additional-segments)

Aside from nesting sections the `control panel` no longer has any interest in your URI pattern after the section segment.


##### Buttons[](#ui/control-panel/introduction/buttons)

Each section can define `buttons` that display when that section is active. Buttons can be used for anything! Very often they are used for displaying `create a new entry` buttons for example.


#### Basic Usage[](#ui/control-panel/basic-usage)

The `control panel` is entirely defined in your `Module` class. When you create a module you can define the `$sections` property to define the control panel structure for that module.


##### Module::$sections[](#ui/control-panel/basic-usage/module-sections)

The `sections` property is used to define the sections for the module.

**Example**

    protected $sections = [
        'products' => [
            'buttons' => [
                'create',
            ],
        ],
        'categories' => [
            'buttons' => [
                'create',
            ],
        ],
    ];


#### The Section Definition[](#ui/control-panel/the-section-definition)

Below is a list of all `section` definition properties available.

###### Properties

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

$slug

</td>

<td>

true

</td>

<td>

string

</td>

<td>

The section array key.

</td>

<td>

The slug will become the URI segment and must be unique.

</td>

</tr>

<tr>

<td>

$title

</td>

<td>

false

</td>

<td>

string

</td>

<td>

{vendor}.module.{module}::section.{slug}.title

</td>

<td>

The section title or translation key.

</td>

</tr>

<tr>

<td>

$description

</td>

<td>

false

</td>

<td>

string

</td>

<td>

{vendor}.module.{module}::section.{slug}.description

</td>

<td>

The section description or translation key.

</td>

</tr>

<tr>

<td>

$buttons

</td>

<td>

false

</td>

<td>

array

</td>

<td>

null

</td>

<td>

An array of button definitions.

</td>

</tr>

<tr>

<td>

$icon

</td>

<td>

false

</td>

<td>

string

</td>

<td>

null

</td>

<td>

A registered icon string or icon class.

</td>

</tr>

<tr>

<td>

$class

</td>

<td>

false

</td>

<td>

string

</td>

<td>

null

</td>

<td>

A CSS class to append to the section.

</td>

</tr>

<tr>

<td>

$matcher

</td>

<td>

false

</td>

<td>

string

</td>

<td>

The section's URL

</td>

<td>

A string pattern to test against a request path to determine if the section is active or not. Example: admin/products/*/variants

</td>

</tr>

<tr>

<td>

$parent

</td>

<td>

false

</td>

<td>

string

</td>

<td>

null

</td>

<td>

The slug of the parent section if any. Sub-sections will not display in the navigation. Sub-sections highlight their parent when active but display their own buttons.

</td>

</tr>

<tr>

<td>

$sections

</td>

<td>

false

</td>

<td>

array

</td>

<td>

null

</td>

<td>

An array of child section definitions. These are placed in the base array and parent set on them automatically.

</td>

</tr>

<tr>

<td>

$attributes

</td>

<td>

false

</td>

<td>

array

</td>

<td>

null

</td>

<td>

An array of `key => value` HTML attributes. Any base level definition keys starting with `data-` will be pushed into attributes automatically.

</td>

</tr>

<tr>

<td>

$href

</td>

<td>

false

</td>

<td>

string

</td>

<td>

admin/{module}/{slug}

</td>

<td>

The HREF to the section. This gets pushed into `attributes` automatically.

</td>

</tr>

<tr>

<td>

$breadcrumb

</td>

<td>

false

</td>

<td>

string|false

</td>

<td>

The section title.

</td>

<td>

The breadcrumb text for the section.

</td>

</tr>

<tr>

<td>

$view

</td>

<td>

false

</td>

<td>

string

</td>

<td>

null

</td>

<td>

The view to delegate the section to.

</td>

</tr>

<tr>

<td>

$html

</td>

<td>

false

</td>

<td>

string

</td>

<td>

null

</td>

<td>

The HTML to display as the section.

</td>

</tr>

<tr>

<td>

$permission

</td>

<td>

false

</td>

<td>

string

</td>

<td>

{vendor}.module.{module}::{slug}.*

</td>

<td>

The permission string required to access the section. Note that builders within the section usually automate permissions so this may not be required if using said builders.

</td>

</tr>

<tr>

<td>

$permalink

</td>

<td>

false

</td>

<td>

string

</td>

<td>

The section URL.

</td>

<td>

The actual permalink for the section in the case that the HREF is used for something different. This is helpful when the HREF used for the section link needs to be different than the actual HREF for the section. Like a section link that opens a modal as in the above example to take you into the section.

</td>

</tr>

</tbody>

</table>


#### Section Handlers[](#ui/control-panel/section-handlers)

Sections also support `handlers` to dynamically control the sections of your module. Set the `$sections` property to a callable string or create a valid handler class next to your module class to be picked up automatically.

    protected $sections = 'Anomaly\ProductsModule\ProductsModuleSections@handle';

The handler is called from the service container and is passed the `$builder`.

    <?php namespace Anomaly\UsersModule;

    use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;

    class UsersModuleSections
    {
        public function handle(ControlPanelBuilder $builder)
        {
            $builder->setSections([
                'users',
                'roles',
                'fields',
            ]);
        }
    }


### Forms[](#ui/forms)

Forms let you easily create and update model objects. Usually they are used with `streams` but are versatile enough to handle API forms, non-model forms, or any form requirements you have.


#### Builders[](#ui/forms/builders)

Form `builders` are the entry point for creating a form. All forms will use a `builder` to convert your basic component `definitions` into their respective classes.


##### Basic Usage[](#ui/forms/builders/basic-usage)

To get started building a form. First create a `FormBuilder` that extends the `\Anomaly\Streams\Platform\Ui\Form\FormBuilder` class.

When using the `make:stream` command form builders are created for you. A generated form builder looks like this:

    <?php namespace Example\TestModule\Test\Form;

    use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

    class TestFormBuilder extends FormBuilder
    {

        /**
         * The form fields.
         *
         * @var array|string
         */
        protected $fields = [];

        /**
         * Fields to skip.
         *
         * @var array|string
         */
        protected $skips = [];

        /**
         * Additional validation rules.
         *
         * @var array|string
         */
        protected $rules = [];

        /**
         * The form actions.
         *
         * @var array|string
         */
        protected $actions = [];

        /**
         * The form buttons.
         *
         * @var array|string
         */
        protected $buttons = [];

        /**
         * The form options.
         *
         * @var array
         */
        protected $options = [];

        /**
         * The form sections.
         *
         * @var array
         */
        protected $sections = [];

        /**
         * The form assets.
         *
         * @var array
         */
        protected $assets = [];

    }


##### FormBuilder::$fields[](#ui/forms/builders/basic-usage/formbuilder-fields)

Form `fields` are the primary building block of a form. Fields define the inputs for your form. If your form uses a stream model then most of the work can be automated for you. However you can also define fields 100% manually too.

**Example**

    protected $fields = [
        'database_driver'       => [
            'label'        => 'anomaly.module.installer::field.database_driver.label',
            'instructions' => 'anomaly.module.installer::field.database_driver.instructions',
            'type'         => 'anomaly.field_type.select',
            'value'        => env('DB_DRIVER', 'mysql'),
            'required'     => true,
            'rules'        => [
                'valid_database',
            ],
            'validators'   => [
                'valid_database' => [
                    'handler' => DatabaseValidator::class,
                    'message' => false,
                ],
            ],
            'config'       => [
                'options' => [
                    'mysql'    => 'MySQL',
                    'pgsql' => 'Postgres',
                    'sqlite'   => 'SQLite',
                    'sqlsrv'   => 'SQL Server',
                ],
            ],
        ],
        'database_host'         => [
            'label'        => 'anomaly.module.installer::field.database_host.label',
            'placeholder'  => 'anomaly.module.installer::field.database_host.placeholder',
            'instructions' => 'anomaly.module.installer::field.database_host.instructions',
            'type'         => 'anomaly.field_type.text',
            'value'        => 'localhost',
            'required'     => true,
        ],
        'database_name'         => [
            'label'        => 'anomaly.module.installer::field.database_name.label',
            'placeholder'  => 'anomaly.module.installer::field.database_name.placeholder',
            'instructions' => 'anomaly.module.installer::field.database_name.instructions',
            'value'        => env('DB_DATABASE', snake_case(strtolower(config('streams::distribution.name')))),
            'type'         => 'anomaly.field_type.text',
            'required'     => true,
        ],
    ];


##### FormBuilder::$skips[](#ui/forms/builders/basic-usage/formbuilder-skips)

The `skips` property is for defining fields to skip. Simply include an array of field slugs.

**Example**

    protected $skips = [
        'example_field',
    ];


##### FormBuilder::$rules[](#ui/forms/builders/basic-usage/formbuilder-rules)

The `rules` property is for defining additional field rules.

**Example**

    protected $rules = [
        'example_field' => [
    		'required',
    		'date:n-j-Y',
        ],
    ];


##### FormBuilder::$sections[](#ui/forms/builders/basic-usage/formbuilder-sections)

Form `sections` help you organize your fields into different field group layouts.

**Example**

    protected $sections = [
        'license'       => [
            'fields' => [
                'license',
            ],
        ],
        'database'      => [
            'fields' => [
                'database_driver',
                'database_host',
                'database_name',
                'database_username',
                'database_password',
            ],
        ],
        'administrator' => [
            'fields' => [
                'admin_username',
                'admin_email',
                'admin_password',
            ],
        ],
        'application'   => [
            'fields' => [
                'application_name',
                'application_reference',
                'application_domain',
                'application_locale',
                'application_timezone',
            ],
        ],
    ];


##### FormBuilder::$actions[](#ui/forms/builders/basic-usage/formbuilder-actions)

Form `actions` determine what your form does when submitted. Most actions assume the form saves and then does something else like redirect to a new form or the same form to continue editing the entry but they can do anything else you need like submitting to APIs or redirecting somewhere.

<div class="alert alert-info">**Note:** Actions extend UI buttons so some actions may use registered buttons to further automate themselves.</div>

**Example**

    protected $actions = [
        'save',
        'save_create',
    ];


##### FormBuilder::$buttons[](#ui/forms/builders/basic-usage/formbuilder-buttons)

Form `buttons` extend base UI buttons and allow you to add simple button links to your form. Form `buttons` do not submit the form.

**Example**

    protected $buttons = [
        'cancel',
        'view',
    ];


##### FormBuilder::$options[](#ui/forms/builders/basic-usage/formbuilder-options)

Form `options` help configure the behavior in general of the form. You can use options for toggling specific UI on or off, adding a simple title and description, or pushing data into the form view.

**Example**

    protected $options = [
        'redirect' => 'admin/products/view/{entry.id}'
    ];


##### FormBuilder::$assets[](#ui/forms/builders/basic-usage/formbuilder-assets)

The `assets` property defines assets to load to load for the form.

**Example**

    protected $assets = [
        'scripts.js' => [
            'theme::js/forms/initialize.js',
            'theme::js/forms/validation.js',
        ],
        'styles.css' => [
            'theme::scss/forms/validation.scss',
        ]
    ];


##### Ajax Forms[](#ui/forms/builders/ajax-forms)

You can easily make forms use ajax behavior by setting the `$ajax` property.

    protected $ajax = true;

You can also flag forms as ajax on the fly.

    $builder->setAjax(true);

Ajax forms are designed to be included in a modal by default but you can configure it to display like a normal form or however you like.

<div class="alert alert-danger">**In Development:** The Ajax API is still being developed. While ajax forms are usable, more robust JSON response information is still missing.</div>


##### Read-only Forms[](#ui/forms/builders/read-only-forms)

To render the form as `read-only` just set the `$readOnly` flag on the `builder`.

    protected $readOnly = true;

You can also set this flag on the fly:

    $builder->setReadOnly(true);


##### Form Handlers[](#ui/forms/builders/form-handlers)

Form `handlers` are responsible for handling the business logic of the form. Generally this is to simply save the form.

The default form handler for example looks like this:

    <?php namespace Anomaly\Streams\Platform\Ui\Form;

    class FormHandler
    {

        /**
         * Handle the form.
         *
         * @param FormBuilder $builder
         */
        public function handle(FormBuilder $builder)
        {
            if (!$builder->canSave()) {
                return;
            }

            $builder->saveForm();
        }
    }


##### Writing Custom Handlers[](#ui/forms/builders/form-handlers/writing-custom-handlers)

You can use your own form handler by defining it in your form builder. Simply define the self handling class or a callable class string.

    protected $handler = \Example\Test\MyCustomHandler::class; // Assumes @handle

    protected $handler = 'Example\Test\AnotherCustomHandler@test';

Now in your form handler you can add your own logic.

    class MyCustomHandler
    {

        public function handle(MyCustomFormBuilder $builder)
        {
            if ($builder->hasFormErrors()) {
                return; // We have errors.. abandon ship!
            }

            // Do amazing stuff here.
        }
    }

<div class="alert alert-primary">**Pro Tip:** Handlers are called using the **Service Container** and support class and method injection.</div>


##### Form Models[](#ui/forms/builders/form-models)

Form `models` are used to determine the form repository to use and provide the model for the system to use when creating and updating an entry.

Form `models` are guessed based on the form builders class. If using `php artisan make:stream` the model property does not need to be set.

If you would like to or have to define the model yourself you can do so on the form `builder`.

    protected $model = \Anomaly\UsersModule\User\UserModel::class;


##### Form Repositories[](#ui/forms/builders/form-repositories)

Form `repositories` are used to create an entry when creating and to update an entry when editing. The repository is guessed based on the type of model used.

If you would like to or need to define the repository yourself you can do so on the form `builder`.

    protected $repository = \Example\Test\FancyFormRepository::class;

The form repository must implement `\Anomaly\Streams\Platform\Ui\Form\Contract\FormRepositoryInterface` and implement the following methods:

    /**
     * Find an entry or return a new one.
     *
     * @param $id
     * @return mixed
     */
    public function findOrNew($id);

    /**
     * Save the form.
     *
     * @param  FormBuilder $builder
     * @return bool|mixed
     */
    public function save(FormBuilder $builder);


##### Including Assets[](#ui/forms/builders/including-assets)

Besides the obvious overriding views to include your own assets you can also specify assets to include with the `$assets` array.

Specify the assets to include per the collection they should be added to.

    protected $assets = [
        'scripts.js' => [
            'theme::js/form/initialize.js',
            'theme::js/form/example.js',
        ],
        'styles.css' => [
            'theme::scss/form/example.scss',
        ]
    ];


#### Fields[](#ui/forms/fields)

Form `fields` are the main building blocks of forms. They control the `inputs` first but also the way data is handled when saving and everything in between.


##### The Field Definition[](#ui/forms/fields/the-field-definition)

Below is a list of all available field definition properties.

###### Properties

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

$slug

</td>

<td>

true

</td>

<td>

string

</td>

<td>

The field definition key.

</td>

<td>

The field slug is used for naming the field input and identifying it amongst other fields.

</td>

</tr>

<tr>

<td>

$label

</td>

<td>

false

</td>

<td>

string

</td>

<td>

The field assignment label or field name if available.

</td>

<td>

The input label.

</td>

</tr>

<tr>

<td>

$instructions

</td>

<td>

false

</td>

<td>

string

</td>

<td>

The field assignment instructions or field instructions.

</td>

<td>

The input instructions.

</td>

</tr>

<tr>

<td>

$warning

</td>

<td>

false

</td>

<td>

string

</td>

<td>

The field assignment warning or field warning.

</td>

<td>

The input warning.

</td>

</tr>

<tr>

<td>

$placeholder

</td>

<td>

false

</td>

<td>

string

</td>

<td>

The field assignment placeholder or field placeholder.

</td>

<td>

The input placeholder.

</td>

</tr>

<tr>

<td>

$type

</td>

<td>

false

</td>

<td>

string

</td>

<td>

The field type.

</td>

<td>

The namespace or slug of a field type to use.

</td>

</tr>

<tr>

<td>

$field

</td>

<td>

false

</td>

<td>

string

</td>

<td>

The streams field slug.

</td>

<td>

The streams field slug to use for populating defaults.

</td>

</tr>

<tr>

<td>

$required

</td>

<td>

false

</td>

<td>

boolean

</td>

<td>

The required status of the field assignment.

</td>

<td>

A shortcut boolean flag to add `required` to the rules array.

</td>

</tr>

<tr>

<td>

$unique

</td>

<td>

false

</td>

<td>

boolean

</td>

<td>

The unique status of the field assignment.

</td>

<td>

A shortcut boolean flag to add `unique` to the rules array.

</td>

</tr>

<tr>

<td>

$rules

</td>

<td>

false

</td>

<td>

array

</td>

<td>

null

</td>

<td>

An array of additional Laravel validation rules.

</td>

</tr>

<tr>

<td>

$validators

</td>

<td>

false

</td>

<td>

array

</td>

<td>

null

</td>

<td>

An array of custom validators keyed by rule.

</td>

</tr>

<tr>

<td>

$prefix

</td>

<td>

false

</td>

<td>

string

</td>

<td>

The prefix of the form.

</td>

<td>

The prefix helps when more than one form are displayed on a page.

</td>

</tr>

<tr>

<td>

$disabled

</td>

<td>

false

</td>

<td>

boolean

</td>

<td>

false

</td>

<td>

Determines whether the field will be disabled or not.

</td>

</tr>

<tr>

<td>

$enabled

</td>

<td>

false

</td>

<td>

boolean

</td>

<td>

true

</td>

<td>

Determines whether the field will be processed or not.

</td>

</tr>

<tr>

<td>

$readonly

</td>

<td>

false

</td>

<td>

boolean

</td>

<td>

false

</td>

<td>

Determines whether the field will be read only or not.

</td>

</tr>

<tr>

<td>

$hidden

</td>

<td>

false

</td>

<td>

boolean

</td>

<td>

false

</td>

<td>

Determines whether the field will be visibly hidden or not.

</td>

</tr>

<tr>

<td>

$config

</td>

<td>

false

</td>

<td>

array

</td>

<td>

null

</td>

<td>

A config array for the field type.

</td>

</tr>

<tr>

<td>

$attributes

</td>

<td>

false

</td>

<td>

array

</td>

<td>

null

</td>

<td>

An array of `key => value` HTML attributes. Any base level definition keys starting with `data-` will be pushed into attributes automatically.

</td>

</tr>

<tr>

<td>

$class

</td>

<td>

false

</td>

<td>

string

</td>

<td>

Varies by field type.

</td>

<td>

A class to append to the attributes.

</td>

</tr>

<tr>

<td>

$input_view

</td>

<td>

false

</td>

<td>

string

</td>

<td>

Varies by field type.

</td>

<td>

A prefixed view to use for the input.

</td>

</tr>

<tr>

<td>

$wrapper_view

</td>

<td>

false

</td>

<td>

string

</td>

<td>

Varies by field type.

</td>

<td>

A prefixed view to use for the field wrapper.

</td>

</tr>

</tbody>

</table>


#### Sections[](#ui/forms/sections)

Sections help you organize your fields into different field groups.


##### The Section Definition[](#ui/forms/sections/the-section-definition)

Below is a list of all possible section definition properties available.

###### Properties

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

slug

</td>

<td>

true

</td>

<td>

string

</td>

<td>

The definition key.

</td>

<td>

The section slug can be used to reference the section later.

</td>

</tr>

<tr>

<td>

title

</td>

<td>

false

</td>

<td>

string

</td>

<td>

{vendor}.module.{module}::{slug}.title

</td>

<td>

The section title.

</td>

</tr>

<tr>

<td>

description

</td>

<td>

false

</td>

<td>

string

</td>

<td>

{vendor}.module.{module}::{slug}.description

</td>

<td>

The section description.

</td>

</tr>

<tr>

<td>

fields

</td>

<td>

false

</td>

<td>

array

</td>

<td>

null

</td>

<td>

The section fields.

</td>

</tr>

<tr>

<td>

tabs

</td>

<td>

false

</td>

<td>

array

</td>

<td>

null

</td>

<td>

The section tab definitions. See below for more information.

</td>

</tr>

<tr>

<td>

attributes

</td>

<td>

false

</td>

<td>

array

</td>

<td>

null

</td>

<td>

An array of `key => value` HTML attributes. Any base level definition keys starting with `data-` will be pushed into attributes automatically.

</td>

</tr>

<tr>

<td>

view

</td>

<td>

false

</td>

<td>

string

</td>

<td>

null

</td>

<td>

The view to delegate the section to.

</td>

</tr>

</tbody>

</table>


##### The Tab Definition[](#ui/forms/sections/the-tab-definition)

Here is a list of all available tab properties.

###### Properties

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

slug

</td>

<td>

true

</td>

<td>

string

</td>

<td>

The definition key.

</td>

<td>

The tab slug is used in it's HTML markup as part of an ID.

</td>

</tr>

<tr>

<td>

title

</td>

<td>

true

</td>

<td>

string

</td>

<td>

none

</td>

<td>

The tab title.

</td>

</tr>

<tr>

<td>

stacked

</td>

<td>

false

</td>

<td>

boolean

</td>

<td>

`false`

</td>

<td>

If `true` then tabs will stack vertically.

</td>

</tr>

<tr>

<td>

fields

</td>

<td>

false

</td>

<td>

array

</td>

<td>

null

</td>

<td>

The tab fields.

</td>

</tr>

</tbody>

</table>


##### Standard Sections[](#ui/forms/sections/standard-sections)

Standard sections simply stack fields on top of each other in a single group.

    protected $sections = [
        'database'      => [
            'title'  => 'Database Information',
            'fields' => [
                'database_driver',
                'database_host',
                'database_name',
                'database_username',
                'database_password'
            ]
        ],
        'administrator' => [
            'title'  => 'Admin Information',
            'fields' => [
                'admin_username',
                'admin_email',
                'admin_password'
            ]
        ],
    ];


##### Tabbed Sections[](#ui/forms/sections/tabbed-sections)

Tabbed sections allow separating fields in the section into tabs.

    protected $sections = [
        'general' => [
             'tabs' => [
                 'form'          => [
                     'title'  => 'module::tab.form',
                     'fields' => [
                         'form_name',
                         'form_slug',
                         'form_description',
                         'success_message',
                         'success_redirect'
                     ]
                 ],
                 'notification'  => [
                     'title'  => 'module::tab.notification',
                     'fields' => [
                         'send_notification',
                         'notification',
                         'notification_send_to',
                         'notification_cc',
                         'notification_bcc'
                     ]
                 ],
             ]
         ]
    ];


##### Section Views[](#ui/forms/sections/section-views)

You can also define a view to handle the entire section.

    protected $sections = [
        'general'      => [
            'view'  => 'module::form/general',
        ],
        'advanced'      => [
            'view'  => 'module::form/advanced',
        ],
    ];


#### Actions[](#ui/forms/actions)

Form `actions` determine what your form does when submitted. Most actions assume the form saves and then does something else like redirect to a new form or the same form to continue editing the entry.


##### The Action Definition[](#ui/forms/actions/the-action-definition)

Below is a list of all action specific definition properties. Actions extend buttons so you can refer to [button documentation](#ui/buttons/the-button-definition) for a complete set of options for buttons.

###### Properties

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

slug

</td>

<td>

true

</td>

<td>

string

</td>

<td>

The definition key.

</td>

<td>

The action becomes the submit button's name.

</td>

</tr>

<tr>

<td>

redirect

</td>

<td>

false

</td>

<td>

string

</td>

<td>

Back to the form.

</td>

<td>

The action redirect URL.

</td>

</tr>

<tr>

<td>

handler

</td>

<td>

false

</td>

<td>

string

</td>

<td>

null

</td>

<td>

A callable class string. This is useful when you want to include additional logic when a form is submitted using an action.

</td>

</tr>

</tbody>

</table>


##### Defining Actions[](#ui/forms/actions/defining-actions)

A `standard` action usually modifies the redirect but can also define a `handler` to perform extra logic too.

    protected $actions = [
        'button'   => 'save',
        'redirect' => 'admin/products/view/{entry.id}',
    ];


##### Using Registered Actions[](#ui/forms/actions/using-registered-actions)

There are a number of actions registered in the `\Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionRegistry` class. To use any of these actions simply include their registered string slug.

    protected $actions = [
        'save',
    ];

The simple slug get's populated from the registered button like this:

    protected $actions = [
        'save' => [
            'button' => 'save',
            'text'   => 'streams::button.save'
        ],
    ];


##### Overriding Registered Actions[](#ui/forms/actions/overriding-registered-actions)

Just like other definitions either registered or automated, you can include more information in your definition to override things.

    protected $actions = [
        'save' => [
            'text' => 'Save Me!'
        ],
    ];


##### The Action Registry[](#ui/forms/actions/the-action-registry)

Below are the basic registered actions. Note the button options that will in turn automate more action properties based on registered buttons. Actions may also simply be registered buttons themselves and allow default handling behavior. Experiment with it!

Registered actions can be found in `Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionRegistry`.

    'update'         => [
        'button' => 'update',
        'text'   => 'streams::button.update'
    ],
    'save_exit'      => [
        'button' => 'save',
        'text'   => 'streams::button.save_exit'
    ],
    'save_edit'      => [
        'button' => 'save',
        'text'   => 'streams::button.save_edit'
    ],
    'save_create'    => [
        'button' => 'save',
        'text'   => 'streams::button.save_create'
    ],
    'save_continue'  => [
        'button' => 'save',
        'text'   => 'streams::button.save_continue'
    ],
    'save_edit_next' => [
        'button' => 'save',
        'text'   => 'streams::button.save_edit_next'
    ],


#### Options[](#ui/forms/options)

Form `options` help configure the behavior in general of the form. Anything from toggling specific UI on or off to adding a simple title and description can be done with the form options.

    protected $options = [
        'title'     => 'My awesome form!',
        'form_view' => 'module::my/custom/form'
    ];

You can also set/add options from the API.

    $builder->addOption('url', 'http://domain.com/example/api');


##### Available Options[](#ui/forms/options/available-options)

Below is a list of all available options for forms.

###### Properties

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

form_view

</td>

<td>

false

</td>

<td>

string

</td>

<td>

streams::form/form

</td>

<td>

The form view is the primary form layout view.

</td>

</tr>

<tr>

<td>

wrapper_view

</td>

<td>

false

</td>

<td>

string

</td>

<td>

streams::blank

</td>

<td>

The wrapper view is the admin layout wrapper. This is the view you would override if you wanted to include a sidebar with your form for example.

</td>

</tr>

<tr>

<td>

permission

</td>

<td>

false

</td>

<td>

string

</td>

<td>

{vendor}.module.{module}::{stream}.write

</td>

<td>

The permission string required to access the form.

</td>

</tr>

<tr>

<td>

url

</td>

<td>

false

</td>

<td>

string

</td>

<td>

The route displaying the form (submits to itself).

</td>

<td>

The URL for the form submission. This is generally automated but varies depending on how the form is being used.

</td>

</tr>

</tbody>

</table>


### Icons[](#ui/icons)

Defining `icons` help abstract how your theme's icons are presented throughout both `admin` and `public` themes. By referring to an icon by a registered universal slug and letting the registry provide the class you can easily swap out icon implementations.


#### Basic Usage[](#ui/icons/basic-usage)

Icon definitions are only a string. If the icon is not found in the registry then the string will be used as-is as the icon class.

    'icon' => 'addon' // <i class="fa fa-puzzle-piece"></i>

    'icon' => 'my-icon' //  <i class="my-icon"></i>


#### The Icon Registry[](#ui/icons/the-icon-registry)

These are all the icons registered in `Anomaly\Streams\Platform\Ui\Icon\IconRegistry` class.

    'addon'                => 'fa fa-puzzle-piece',
    'adjust'               => 'glyphicons glyphicons-adjust-alt',
    'airplane'             => 'glyphicons glyphicons-airplane',
    'amex'                 => 'fa fa-cc-amex',
    'arrows-h'             => 'fa fa-arrows-h',
    'arrows-v'             => 'fa fa-arrows-v',
    'ban'                  => 'fa fa-ban',
    'bars'                 => 'fa fa-bars',
    'brush'                => 'glyphicons glyphicons-brush',
    'calendar'             => 'glyphicons glyphicons-calendar',
    'car'                  => 'glyphicons glyphicons-car',
    'check'                => 'fa fa-check',
    'check-circle'         => 'fa fa-check-circle',
    'check-circle-alt'     => 'fa fa-check-circle-o',
    'check-square-alt'     => 'fa fa-check-square-o',
    'circle'               => 'fa fa-circle',
    'circle-alt'           => 'fa fa-circle-o',
    'circle-question-mark' => 'glyphicons glyphicons-circle-question-mark',
    'cloud-plus'           => 'glyphicons glyphicons-cloud-plus',
    'cloud-upload'         => 'fa fa-cloud-upload',
    'cloud-upload-alt'     => 'glyphicons glyphicons-cloud-upload',
    'code'                 => 'fa fa-code',
    'code-fork'            => 'fa fa-code-fork',
    'cog'                  => 'fa fa-cog',
    'cogs'                 => 'fa fa-cogs',
    'comments'             => 'glyphicons glyphicons-comments',
    'compress'             => 'fa fa-compress',
    'conversation'         => 'glyphicons glyphicons-conversation',
    'credit-card'          => 'glyphicons glyphicons-credit-card',
    'cubes'                => 'fa fa-cubes',
    'dashboard'            => 'fa fa-dashboard',
    'database'             => 'fa fa-database',
    'diners-club'          => 'fa  fa-cc-diners-club',
    'discover'             => 'fa fa-cc-discover',
    'download'             => 'fa fa-download',
    'duplicate'            => 'glyphicons glyphicons-duplicate',
    'envelope'             => 'fa fa-envelope',
    'envelope-alt'         => 'fa fa-envelope-o',
    'exchange'             => 'fa fa-exchange',
    'exit'                 => 'fa fa-sign-out',
    'expand'               => 'fa fa-expand',
    'external-link'        => 'fa fa-external-link',
    'eyedropper'           => 'glyphicons glyphicons-eyedropper',
    'facebook'             => 'fa fa-facebook',
    'facebook-square'      => 'fa fa-facebook-square',
    'facetime-video'       => 'glyphicons glyphicons-facetime-video',
    'file'                 => 'fa fa-file-o',
    'file-image'           => 'fa fa-file-image-o',
    'film'                 => 'fa fa-film',
    'filter'               => 'fa fa-filter',
    'fire'                 => 'glyphicons glyphicons-fire',
    'flag'                 => 'fa fa-flag',
    'folder-closed'        => 'glyphicons glyphicons-folder-closed',
    'folder-open'          => 'glyphicons glyphicons-folder-open',
    'fullscreen'           => 'glyphicons glyphicons-fullscreen',
    'git-branch'           => 'glyphicons glyphicons-git-branch',
    'global'               => 'glyphicons glyphicons-global',
    'globe'                => 'glyphicons glyphicons-globe',
    'home'                 => 'fa fa-home',
    'jcb'                  => 'fa fa-cc-jcb',
    'keys'                 => 'glyphicons glyphicons-keys',
    'language'             => 'fa fa-language',
    'laptop'               => 'fa fa-laptop',
    'link'                 => 'glyphicons glyphicons-link',
    'list-alt'             => 'fa fa-list-alt',
    'list-ol'              => 'fa fa-list-ol',
    'list-ul'              => 'fa fa-list-ul',
    'lock'                 => 'fa fa-lock',
    'locked'               => 'fa fa-lock',
    'magic'                => 'glyphicons glyphicons-magic',
    'map-marker'           => 'fa fa-map-marker',
    'mastercard'           => 'fa fa-cc-mastercard',
    'minus'                => 'fa fa-minus',
    'newspaper'            => 'fa fa-newspaper-o',
    'options'              => 'fa fa-options',
    'order'                => 'glyphicons glyphicons-sort',
    'paperclip'            => 'glyphicons glyphicons-paperclip',
    'paypal'               => 'fa fa-cc-paypal',
    'pencil'               => 'fa fa-pencil',
    'percent'              => 'fa fa-percent',
    'phone'                => 'fa fa-phone',
    'picture'              => 'glyphicons glyphicons-picture',
    'play'                 => 'fa fa-play',
    'plug'                 => 'fa fa-plug',
    'plus'                 => 'fa fa-plus',
    'plus-circle'          => 'fa fa-plus-circle',
    'plus-square'          => 'fa fa-plus-square',
    'power-off'            => 'fa fa-power-off',
    'question'             => 'fa fa-question',
    'question-circle'      => 'fa fa-question-circle',
    'quote-left'           => 'fa fa-quote-left',
    'quote-right'          => 'fa fa-quote-right',
    'redo'                 => 'glyphicons glyphicons-redo',
    'refresh'              => 'fa fa-refresh',
    'repeat'               => 'fa fa-repeat',
    'retweet'              => 'glyphicons glyphicons-retweet',
    'rss'                  => 'fa fa-rss',
    'rss-square'           => 'fa fa-rss-square',
    'save'                 => 'fa fa-save',
    'scissors'             => 'glyphicons glyphicons-scissors-alt',
    'search'               => 'fa fa-search',
    'server'               => 'glyphicons glyphicons-server',
    'share'                => 'fa fa-share-alt',
    'shopping-cart'        => 'glyphicons glyphicons-shopping-cart',
    'sign-in'              => 'fa fa-sign-in',
    'sign-out'             => 'fa fa-sign-out',
    'sitemap'              => 'fa fa-sitemap',
    'sliders'              => 'fa fa-sliders',
    'sort-ascending'       => 'glyphicons glyphicons-sort-by-attributes',
    'sort-descending'      => 'glyphicons glyphicons-sort-by-attributes-alt',
    'sortable'             => 'glyphicons glyphicons-sorting',
    'square'               => 'fa fa-square',
    'square-alt'           => 'fa fa-square-o',
    'star'                 => 'fa fa-star',
    'stripe'               => 'fa-cc-stripe',
    'tag'                  => 'fa fa-tag',
    'tags'                 => 'fa fa-tags',
    'th'                   => 'fa fa-th',
    'th-large'             => 'fa fa-th-large',
    'thumbnails'           => 'glyphicons glyphicons-thumbnails',
    'times'                => 'fa fa-times',
    'times-circle'         => 'fa fa-times-circle',
    'times-square'         => 'fa fa-times-square',
    'translate'            => 'glyphicons glyphicons-translate',
    'trash'                => 'fa fa-trash',
    'truck'                => 'fa fa-truck',
    'twitter'              => 'fa fa-twitter',
    'unlock'               => 'fa fa-unlock',
    'upload'               => 'fa fa-upload',
    'usd'                  => 'fa fa-usd',
    'user'                 => 'fa fa-user',
    'users'                => 'fa fa-users',
    'video-camera'         => 'fa fa-video-camera',
    'warning'              => 'fa fa-warning',
    'wrench'               => 'fa fa-wrench',
    'youtube'              => 'fa fa-youtube',


### Tables[](#ui/tables)

Tables let you easily display a table of stream entries. They can also be used without streams using regular Eloquent models or without any database backend at all by manually loading entries.


#### Builders[](#ui/tables/builders)

Table `builders` are the entry point for creating a table. All tables will use a `builder` to convert your basic component `definitions` into their respective classes.


##### Basic Usage[](#ui/tables/builders/basic-usage)

To get started building a table. First create a `TableBuilder` that extends the `\Anomaly\Streams\Platform\Ui\Table\TableBuilder` class.

When using the `make:stream` command table builders are created for you. A generated table builder looks like this:

    <?php namespace Example\TestModule\Test\Table;

    use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

    class TestTableBuilder extends TableBuilder
    {

        /**
         * The table views.
         *
         * @var array|string
         */
        protected $views = [];

        /**
         * The table filters.
         *
         * @var array|string
         */
        protected $filters = [];

        /**
         * The table columns.
         *
         * @var array|string
         */
        protected $columns = [];

        /**
         * The table buttons.
         *
         * @var array|string
         */
        protected $buttons = [
            'edit'
        ];

        /**
         * The table actions.
         *
         * @var array|string
         */
        protected $actions = [
            'delete'
        ];

        /**
         * The table options.
         *
         * @var array
         */
        protected $options = [];

        /**
         * The table assets.
         *
         * @var array
         */
        protected $assets = [];
    }


##### TableBuilder::$filters[](#ui/tables/builders/basic-usage/tablebuilder-filters)

Table `filters` let you easily define inputs that filter the results of the table.

**Example**

    protected $filters = [
        'title',
        'category',
        'description',
    ];


##### TableBuilder::$columns[](#ui/tables/builders/basic-usage/tablebuilder-columns)

Table `columns` are the basic building block of the table.

**Example**

    protected $columns = [
        'title',
        'category',
        'description',
    ];


##### TableBuilder::$buttons[](#ui/tables/builders/basic-usage/tablebuilder-buttons)

Table `buttons` display in the last column of each row.

**Example**

    protected $buttons = [
        'edit',
        'view',
    ];


##### TableBuilder::$actions[](#ui/tables/builders/basic-usage/tablebuilder-actions)

Table `actions` let you define submittable buttons that perform an action on the selected rows.

**Example**

    protected $actions = [
        'delete',
    ];


##### Ajax Tables[](#ui/tables/builders/ajax-tables)

You can easily make tables use ajax behavior by setting the `$ajax` property.

    protected $ajax = true;

You can also mark tables ajax on the fly.

    $builder->setAjax(true);

Ajax tables are designed to be included in a modal by default but you can configure it to display like a normal table or however you like.


##### Table Models[](#ui/tables/builders/table-models)

Table models are used to determine the table repository to use and provide the model for the system to use when creating and updating an entry.

Table models are guessed based on the table builders position first. If using `php artisan make:stream` the model does not need to be set.

If an entry object is set the model will be pulled off of that next.

Lastly if you would like to or need to define a model yourself you can do so on the table builder.

    protected $model = UserModel::class;


##### Table Repositories[](#ui/tables/builders/table-repositories)

Table repositories are used to create an entry when creating and to update an entry when editing. The repository is guessed based on the type of model used.

If you would like to or need to define a repository yourself you can do so on the table builder.

    protected $repository = FancyTableRepository::class;


##### Including Assets[](#ui/tables/builders/including-assets)

Besides the obvious overriding views to include your own assets you can also specify assets to include with the `$assets` array.

Specify the assets to include per the collection they should be added to.

    protected $assets = [
        'scripts.js' => [
            'theme::js/tables/initialize.js',
            'theme::js/tables/validation.js',
        ],
        'styles.css' => [
            'theme::scss/tables/validation.scss',
        ]
    ];


#### Filters[](#ui/tables/filters)

Filter definitions display filters to help find entry sets.


##### Defining Filters[](#ui/tables/filters/defining-filters)

You can also define filters manually.

    protected $filters = [
        'title' => [
            'type' => 'text',
            'query' => \Example\Test\FilterQuery::class, // Assumes @handle
        ],
    ];


##### Using Field Filters[](#ui/tables/filters/using-field-filters)

To specify filters from the entry stream being used simply define the filters by the field slug:

    protected $filters = [
        'title',
        'category',
        'description',
    ];


##### Custom Filter Queries[](#ui/tables/filters/custom-filter-queries)

While the filter querying is generally handled 100% automatically. You can provide your own filtering logic as well:

    protected $filters = [
        'title' => [
            'query' => \Example\Test\CustomQuery::class
        ],
    ];

The query class must accept the query `Builder`, `Filter` instance, and is called with the service container.

    <?php namespace Example\Test;

    use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract\FilterInterface;

    class CustomFilter
    {

        /**
         * Handle the filter.
         *
         * @param Builder         $query
         * @param FilterInterface $filter
         */
        public function handle(Builder $query, FilterInterface $filter)
        {
            $query->where($filter->getSlug(), 'LIKE', "%{$filter->getValue()}%");
        }
    }

<div class="alert alert-primary">**Pro Tip:** Even automated stream filters can be completely overridden. Try providing your own custom query!</div>


##### The Filter Definition[](#ui/tables/filters/the-filter-definition)

Below is a list of all possible filter definition properties available.

###### Properties

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

slug

</td>

<td>

true

</td>

<td>

string

</td>

<td>

The definition value/key.

</td>

<td>

The filter slug is used for naming the filter input and identifying it amongst other filters.

</td>

</tr>

<tr>

<td>

heading

</td>

<td>

false

</td>

<td>

string

</td>

<td>

The filter assignment name.

</td>

<td>

The filter label.

</td>

</tr>

<tr>

<td>

placeholder

</td>

<td>

false

</td>

<td>

string

</td>

<td>

The filter label.

</td>

<td>

The filter input placeholder.

</td>

</tr>

<tr>

<td>

filter

</td>

<td>

true

</td>

<td>

string

</td>

<td>

`\Anomaly\Streams\Platform\Ui\Table\Component\Filter\Type\InputFilter`

</td>

<td>

The filter class.

</td>

</tr>

<tr>

<td>

query

</td>

<td>

true

</td>

<td>

string

</td>

<td>

`\Anomaly\Streams\Platform\Ui\Table\Component\Filter\Query\GenericFilterQuery`

</td>

<td>

The custom filter class to use.

</td>

</tr>

</tbody>

</table>


#### Columns[](#ui/tables/columns)

Column definitions are the primary building block of a table. If your table uses a stream model then most of the work can be automated for you. However you can also define columns 100% manually too.


##### The Column Definition[](#ui/tables/columns/the-column-definition)

Below is a list of all possible column definition properties available.

###### Properties

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

value

</td>

<td>

true

</td>

<td>

string

</td>

<td>

none

</td>

<td>

The valuated string for the coumn text value. You can pass an array of values and merge them into the wrapper too.

</td>

</tr>

<tr>

<td>

slug

</td>

<td>

false

</td>

<td>

string

</td>

<td>

The definition key

</td>

<td>

The column slug is used for naming the column input and identifying it amongst other columns.

</td>

</tr>

<tr>

<td>

heading

</td>

<td>

false

</td>

<td>

string

</td>

<td>

The column assignment name.

</td>

<td>

The column label.

</td>

</tr>

<tr>

<td>

column

</td>

<td>

false

</td>

<td>

string

</td>

<td>

`\Anomaly\Streams\Platform\Ui\Table\Component\Column\Column`

</td>

<td>

The custom column class to use.

</td>

</tr>

<tr>

<td>

wrapper

</td>

<td>

false

</td>

<td>

string

</td>

<td>

`{value}`

</td>

<td>

The column value wrapper.

</td>

</tr>

<tr>

<td>

view

</td>

<td>

false

</td>

<td>

string

</td>

<td>

null

</td>

<td>

The view to delegate the column to.

</td>

</tr>

<tr>

<td>

class

</td>

<td>

false

</td>

<td>

string

</td>

<td>

null

</td>

<td>

The column class. Includes the heading row.

</td>

</tr>

</tbody>

</table>


##### Defining Manual Columns[](#ui/tables/columns/defining-manual-columns)

You can also define columns manually. Take a look at how the `FileTableBuilder` does it.

    protected $columns = [
        'entry.preview' => [
            'heading' => 'anomaly.module.files::field.preview.name'
        ],
        'name'          => [
            'sort_column' => 'name',
            'wrapper'     => '
                    <strong>{value.file}</strong>
                    <br>
                    <small class="text-muted">{value.disk}://{value.folder}/{value.file}</small>
                    <br>
                    <span>{value.size} {value.keywords}</span>',
            'value'       => [
                'file'     => 'entry.name',
                'folder'   => 'entry.folder.slug',
                'keywords' => 'entry.keywords.labels',
                'disk'     => 'entry.folder.disk.slug',
                'size'     => 'entry.size_label'
            ]
        ],
        'size'          => [
            'sort_column' => 'size',
            'value'       => 'entry.readable_size'
        ],
        'mime_type',
        'folder'
    ];

<div class="alert alert-primary">**Pro Tip:** Automated stream columns can be overridden too!</div>


##### Using Stream Columns[](#ui/tables/columns/using-stream-columns)

To specify columns from the entry stream being used simply include the column slugs of the assigned columns.

    protected $columns = [
        'title',
        'category',
        'description',
    ];

Just like other UI definitions you can override automation and defaults by including more intableation.

    protected $columns = [
        'title' => [
            'heading' => 'Example Title'
        ],
        'category',
        'description',
    ];

<div class="alert alert-info">**Note:** Tables using streams without defined columns will default to the title column (ID by default) only.</div>


#### Actions[](#ui/tables/actions)

Actions determine available mass actions for the table when 1 or more rows are selected.

<div class="alert alert-info">**Note:** Actions extend UI buttons so some actions may use registered buttons to further automate themselves.</div>


##### The Action Definition[](#ui/tables/actions/the-action-definition)

Below is a list of all action specific definition properties available. Since actions extend buttons please refer to UI button documentation for a complete set of options for buttons.

###### Properties

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

slug

</td>

<td>

true

</td>

<td>

string

</td>

<td>

The definition key.

</td>

<td>

The action slug helps separate it from others.

</td>

</tr>

<tr>

<td>

permission

</td>

<td>

false

</td>

<td>

string

</td>

<td>

null

</td>

<td>

The required permission to view/execute the action.

</td>

</tr>

<tr>

<td>

handler

</td>

<td>

true

</td>

<td>

string

</td>

<td>

none

</td>

<td>

A callable class string or closure. The handler is passed an array of selected IDs from the table as well as the table builder itself.

</td>

</tr>

</tbody>

</table>


##### The Action Registry[](#ui/tables/actions/the-action-registry)

Below are the registered basic actions. Note the button options that will in turn automate more action properties. Actions may also simply be buttons and allow default handling behavior. So be sure to refer to the button registry for more options.

Registered actions can be found in `Anomaly\Streams\Plattable\Ui\Table\Component\Action\ActionRegistry`.

    'delete'       => [
        'handler' => Delete::class
    ],
    'prompt'       => [
        'handler' => Delete::class
    ],
    'force_delete' => [
        'button'  => 'prompt',
        'handler' => ForceDelete::class,
        'text'    => 'streams::button.force_delete',
    ],
    'export'       => [
        'button'  => 'info',
        'icon'    => 'download',
        'handler' => Export::class,
        'text'    => 'streams::button.export'
    ],
    'edit'         => [
        'handler' => Edit::class
    ],
    'reorder'      => [
        'handler' => Reorder::class,
        'text'    => 'streams::button.reorder',
        'icon'    => 'fa fa-sort-amount-asc',
        'class'   => 'reorder',
        'type'    => 'success'
    ]


##### Using Registered Actions[](#ui/tables/actions/using-registered-actions)

There are a number of actions registered in the `Anomaly\Streams\Plattable\Ui\Table\Component\Action\ActionRegistry` class. To use any of these actions simply include their string slug.

    protected $actions = [
        'delete',
    ];

The full definition registered to the above actions is as follows.

    protected $actions = [
        'delete' => [
            'handler' => \Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler\Delete::class
        ],
    ];

After the `delete` button properties are merged in it looks like this:

    protected $actions = [
        'delete' => [
            'icon'       => 'trash',
            'type'       => 'danger',
            'text'       => 'streams::button.delete',
            'attributes' => [
                'data-toggle'  => 'confirm',
                'data-message' => 'streams::message.confirm_delete',
            ],
            'handler' => \Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler\Delete::class
        ],
    ];


##### Overriding Registered Actions[](#ui/tables/actions/overriding-registered-actions)

Just like other definitions either registered or automated, you can include more information in your definition to override things:

    protected $actions = [
        'delete' => [
            'text' => 'Delete rows!'
        ],
    ];


##### The Action Handler[](#ui/tables/actions/the-action-handler)

Below is an example of the action handler.

    <?php namespace Example\Test;

    use Anomaly\Streams\Platform\Ui\Table\Component\Action\ActionHandler;

    class ExampleHandler extends ActionHandler
    {

        public function handle(ExampleTableBuilder $builder, array $selected)
        {
            $model = $builder->getTableModel();

            foreach ($selected as $id) {

                $entry = $model->find($id);

                // Do something here
            }

            if ($selected) {
                $this->messages->success('Something amazing was done!');
            }
        }
    }


#### Options[](#ui/tables/options)

Table `options` help configure the behavior in general of the table. Anything from toggling specific UI on or off to adding a simple title and description can be done with the table options.

    protected $options = [
        'title' => 'My awesome table!',
        'table_view' => 'module::my/custom/table'
    ];

You can also set/add options from the API.

    $builder->addOption('title', 'Example Title');


##### Available Options[](#ui/tables/options/available-options)

Below is a list of all available options for tables.

###### Options

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

table_view

</td>

<td>

false

</td>

<td>

string

</td>

<td>

streams::table/table

</td>

<td>

The table view is the primary table layout view.

</td>

</tr>

<tr>

<td>

wrapper_view

</td>

<td>

false

</td>

<td>

string

</td>

<td>

streams::blank

</td>

<td>

The wrapper view is the admin layout wrapper. This is the view you would override if you wanted to include a sidebar with your table for example.

</td>

</tr>

<tr>

<td>

permission

</td>

<td>

false

</td>

<td>

string

</td>

<td>

{vendor}.module.{module}::{stream}.read

</td>

<td>

The permission string required to access the table.

</td>

</tr>

</tbody>

</table>
