<?php
/**
* Return an json string that is used as data attribute in the HTML elements
* to allow implementing conditionl logic on the associated field
*
* @param string $action is the action type ( hide | show )
* @param array $rules hold the rules for this specific field, it shoud contain ( name & operator ( is|isnot|greaterthan|lessthan|contains|doesnotcontain|beginswith|doesnotbeginwith|endswith|doesnotendwith|isempty|isnotempty  ) & value )
* @param string $logic is the logic type ( and | or )
* @param string $container the conditional field parent element where you want to perform the hiding/showing action, leave empty to show/hide the field itself
* @return string
*/
function get_mf_conditional_rules( $action, $rules, $logic = 'or', $container = '.form-group' ) {

  return json_encode( array(
          'container' => $container,
          'action' => $action,
          'logic' => $logic,
          'rules' => $rules,
        ));
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>MF Conditional Fields</title>
    </head>
    <body>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
      <div class="container" style="padding-top:50px; padding-bottom:50px;">
          <form id="example_form">
            <h3 class="mb-5">Basic Example</h3>
            <?php
            /*
            * Example 1
            */
            # Parent field
            ?>
            <div class="form-group">
              <label for="field1">Parent Field</label>
              <input type="checkbox" name="parent_field" id="field1" value="yes" />
            <div>


            <?php
            # Dependant fields
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
            # Dependant element
            $condition2 = get_mf_conditional_rules( 'hide', array(
              'name' => 'parent_field',
              'operator' => 'is',
              'value' => 'yes'
            ), 'or', '.alert-primary' );
            ?>
            <div class="alert alert-primary" role="alert">
              Please check the checkbox above!
              <input type="hidden" name="dependant_container" data-conditional-rules="<?php echo htmlspecialchars($condition2); ?>" />
            </div>

            <div class="dropdown-divider"></div>
            <h3 class="mb-5">Multiple Rules Example</h3>
            <?php
            /*
            * Example 2
            */
            # Parent field
            ?>
            <div class="form-group">
              <input type="radio" id="male" name="gender" value="male">
              <label for="male">Male</label><br>
              <input type="radio" id="female" name="gender" value="female">
              <label for="female">Female</label><br>
              <input type="radio" id="other" name="gender" value="other">
              <label for="other">Other</label>
            </div>

            <?php
            # Dependant element
            $condition3 = get_mf_conditional_rules( 'show', array(
              array(
                'name' => 'gender',
                'operator' => 'is',
                'value' => 'male'
              ),
              array(
                'name' => 'gender',
                'operator' => 'is',
                'value' => 'female'
              ),
            ), 'or', '.alert-primary' );
            ?>
            <div class="alert alert-primary" role="alert">
              This alert is attached to 'male' and 'female' options.
              <input type="hidden" name="dependant_container2" data-conditional-rules="<?php echo htmlspecialchars($condition3); ?>" />
            </div>

            <?php
            # Dependant field
            $condition4 = get_mf_conditional_rules( 'show', array(
              'name' => 'gender',
              'operator' => 'is',
              'value' => 'other'
            ));
            ?>
            <div class="form-group" role="alert">
              <label for="field1">Type your gender:</label>
              <input type="text" name="dependant_field2" data-conditional-rules="<?php echo htmlspecialchars($condition4); ?>" />
            </div>
            <div class="dropdown-divider"></div>


            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </form>
      </div>
      <script src="../dist/mf-conditional-fields.min.js"></script>
      <script>
        mfConditionalFields('#example_form');
      </script>
    </body>
</html>
<?php
