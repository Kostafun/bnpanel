<script>
$(document).ready(function() {
    $("#editTheTplNao").click(function() {
        $("#" + this.id).blur();
        $("#" + this.id).attr("disabled", "disabled");
        var code = $("#tplCode").val();
        $.post("{$ajax}function=edittpl", { file: "footer", contents: code }, function(data){
            if(data == 'Trying to remove the copyright? No thanks.') {
                $.get("{$ajax}function=notice", { status: "bad", message: data }, function(data2){
                    $("#belowDynamic").slideUp(500, function() {
                        $("#spaceForNotice").html(data2);
                        $("#editTheTplNao").removeAttr("disabled");
                        $("#belowDynamic").slideDown(500);
                    });
                });
            }
            else {
                $.get("{$ajax}function=notice", { status: "good", message: data }, function(data2){
                    $("#belowDynamic").slideUp(500, function() {
                        $("#spaceForNotice").html(data2);
                        $("#editTheTplNao").removeAttr("disabled");
                        $("#belowDynamic").slideDown(500);
                    });
                });
            }
        });
    });
    $("#refreshButton").click(function() {
        window.location.reload();
    });
});
</script>
<strong>Editing your Footer Template</strong><br />
<p>Want to edit your style in an web based interface? Here it is!<br /><br />
<em>Variables:</em><br /> &lt;PAGEGEN&gt; tag shows the debug stuff.<br />
&lt;COPYRIGHT&gt; shows the Copyright. <br />
<textarea cols="75" style="width:99%; height:300px;" id="tplCode" rows="25" wrap="no" name="edit" READONLY>
{$CSSCONTENT}</textarea>
<div id="belowDynamic">
    <div id="spaceForButton">
        <button id="editTheTplNao"{$DISABLED}>Edit Footer</button><button id="refreshButton" style="float: right;">Refresh</button>
    </div>
    <div id="spaceForNotice" style="font-weight: bold; font-style: italic;">
        {$NOTICE}
    </div>
</div>
