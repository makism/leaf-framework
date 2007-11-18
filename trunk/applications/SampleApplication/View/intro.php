
<div style="background-color: #ddffdd; border: 1px solid #bbffbb; padding: 4px; width: 520px;">
    <span style="font-weight: bold; font-size: 20px;">Welcome to the leaf framework!</span><br />
    <span style="font-style: italic;">This is a test View, displayed by the Sample Application`s Controller.</span>
</div>

<br />

<div style="font-size: 10px;">
     &middot
     <?php
        $opts = array (
            "qstring" => array (
                "append" => array(
                    "debug" => NULL,
                    "rel"   => "alpha"
                )
            )
        );
        echo make_link(make_link_curr(), "Show debug statistics", $opts);
     ?>
</div>
