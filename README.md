# MF Conditional Fields

A JavaScript library that show/hide form elements based on the value of one field or many.

![MF Conditional Fields](/images/mf-conditional-rules.gif)

**Advantages**
- Lightweight & fast.
- Comes with a number of different operators.
- Supports complex conditional rules.
- Supports dynamic forms ( forms that are updated with new elements after the dom is loaded ).
- Supports all form elements regardless of their type ( input, select..etc ).

**Disadvantages**
- JSON based and large conditions, which makes writing rules a bit fraustrating. However, you can always write you own helpers to create rules faster ( See jQuery and PHP usage for examples )

## When To Use

This library is best suited for complex conditions and dynamically generated fields. Field conditions are written in JSON format and it can be hard to generate these manually.

If you plan on using this for your PHP project, make sure to check out the **PHP Usage** section below.

If you want to use jQuery, you'll need to write your own function or plugin to supply your rules as **array of object** to `mfConditionalFields( '.formSelecotr', rulesArray )`. ( see **Block Condition Format** section for the correct format )

## How To Use

1. Load `src/mf-conditional-fields.js`.
2. Add your JSON formatted conditions inside a JS template or to the field you want to show/hide inside a `data-conditional-rules` attribute.
3. Call `mfConditionalFields('form')`  *(replace `form` with your form selector)*

4. Let the magic happen

### Inline Condition Format

    {
       "container":".element-to-show-hide",
       "action":"show",
       "logic":"or",
       "rules":[
          {
             "name":"parent_field_name",
             "operator":"is",
             "value":"parent_field_targeted_value"
          }
       ]
    }

### Block Condition Format
    [
        {
           "field":"field1_name",
           "container":".element-to-show",
           "action":"show",
           "logic":"or",
           "rules":[
              {
                 "name":"parent_field_name",
                 "operator":"is",
                 "value":"parent_field_targeted_value"
              }
           ]
        },
        {
            "field":"field1_name",
            "container":".element-to-hide",
            "action":"hide",
            "logic":"or",
            "rules":[
              {
                 "name":"parent_field_name",
                 "operator":"isnot",
                 "value":"parent_field_targeted_value"
              }
           ]
        },
    ]

### Field
The name attribute of the field you want to show/hide based on the provided rules. Note that this can only be used in the **block based rules**, **inline based rules** don't require this. ( if you are not fimiliar with the bold terms, please keep reading )

### Container
The conditional field parent element where you want to perform the hiding/showing action, leave empty to show/hide the field itself.

### Action
  - show
  - hide

### Logic

  - or ( ***meeting one of the rules is enough perform the action*** )
  - and ( ***all the rules must be met to perform the action*** )

### Rules
This should contain the rules you want to meet before showing/hiding the field. The rules can accept one rule in simple format `{"name": "a", "operator": "is", "value": "yes"}` or multiple rules `[{"name": "a", "operator": "is", "value": "yes"}, {"name": "b", "operator": "is", "value": "no"}]`

#### Name
The name attribute of the parent field where the script should be listening for changes

#### Operator
Comparision operators to compare between the parent field value and the rule value

- is
- isnot
- greaterthan
- lessthan
- contains
- doesnotcontain
- beginswith
- doesnotbeginwith
- endswith
- doesnotendwith
- isempty
- isnotempty

#### Value
The parent field value we should be watching for to perform the action, this can accept one value, if you want to use more values, you'll need to create more rules.

_________________________________________
## Usage

### PHP Usage ( Inline Rules )
- Create a helper function

      function get_mf_conditional_rules( $action, $rules, $logic = 'or', $container = '.default-field-container' ) {

        return json_encode( array(
                'container' => $container,
                'action' => $action,
                'logic' => $logic,
                'rules' => $rules,
              ));
      }

- Create your form and give it an id or class to use for initilizations

        ?>
            <form id="example_form">
            </form>
        <?php

- Create parent field (**trigger**)

        ?>
            <div class="form-group">
                <label for="field1">Parent Field</label>   
                <input type="checkbox" name="parent_field" id="field1" value="yes"/>
            <div>
        <?php
- Create you conditional rules and field like this (**dependant field**)

        $condition1 = get_mf_conditional_rules( 'show', array(
          'name' => 'parent_field',
          'operator' => 'is',
          'value' => 'yes'
        ) );
        ?>
            <div class="form-group">
              <label for="field2">Dependant Field</label><br>
              <input type="text" name="dependant_field" id="field2" data-conditional-rules="<?php echo htmlspecialchars($condition1); ?>" />
            </div>
        <?php

- Load the library and Initialize conditional fields

        ?>
          <script src="../src/mf-conditional-fields.js"></script>
          <script>
            mfConditionalFields('#example_form');
          </script>
        <?php

### Plain HTML Usage ( Block Based Rules )

- Create your form and give it an id or class to use for initilizations

        <form id="example_form">
        </form>

- Create parent field (**trigger**)

        <div class="form-group">
            <label for="field1">Parent Field</label>   
            <input type="checkbox" name="parent_field" id="field1" value="yes"/>
        <div>

- Create you conditional field  (**dependant field**)

        <div class="form-group">
          <label for="field2">Dependant Field</label><br>
          <input type="text" name="dependant_field" id="field2" />
        </div>

- Create a script element and give it the id attribute `rules-mf-conditional-fields`

        <script type="text/x-rules" id="rules-mf-conditional-fields">
            // Rules here
        </script>

- Create your conditions based on the **block based rules** format and put them inside the script element you created

        [
           {
              "field":"dependant_field",
              "container":".form-group",
              "action":"show",
              "logic":"or",
              "rules":{
                 "name":"parent_field",
                 "operator":"is",
                 "value":"yes"
              }
           }
        ]


- Load the library and Initialize conditional fields ( make sure to add `block` as a second arguement when calling `mfConditionalFields` )

      <script src="../src/mf-conditional-fields.js"></script>
      <script>
        mfConditionalFields('#example_form', 'block');
      </script>

_________________________________________
## Usage With Dynamic Forms
To use dynamic forms functionality, you must use **inline based rules** and initiaize the form like this

    mfConditionalFields('#example_form', 'inline', true);

Then, you must trigger the event `mfConditionalFormUpdated` each time you add or remove fields. After you do that, the script will implement conditional logic to any new conditional fields in form. ( change the value `add` to `remove` if a field is remove )

    let mfEvent = new CustomEvent("mfConditionalFormUpdated", { "detail": { "action": "add" } });
    document.getElementById('example_form').dispatchEvent(mfEvent);

_____________________________________________

### Have an issue or suggestion?
Feel free to share any issues or feature requests by creating an [issue](https://github.com/bomsn/mf-conditional-fields/issues)

### Want to contribute?
Fork, change, send pull request!
