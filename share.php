<?php

$url     = !empty($_POST['url'])     ? $_POST['url']     : false;
$comment = !empty($_POST['comment']) ? $_POST['comment'] : false;

if ($url && $comment && ($scheme = parse_url($url, PHP_URL_SCHEME)) && !empty($scheme)) {
    global $facebook, $twitter;

    $twitter->share($url, $comment);
    $facebook->share($url, $comment);

    $result = true;
    unset($url, $comment);
}

?>

<div class="wrap">
    <h2>Socialize</h2>

    <?php if ($result): ?>
         <div class="updated">
            <p><strong>Link successfully shared!</strong></p>
        </div>
    <?php endif; ?>

    <form method="post" action "<?php echo SETTINGS_URL; ?>-share">
        <table class="form-table">
            <tr valign="top">
                <th scope="row">URL</th>
                <td><input type="text" name="url" value="<?php echo $url; ?>" size="120" /></td>
            </tr>
            <tr valign="top">
                <th scope="row">Comment</th>
                <td><input type="text" name="comment" value="<?php echo $comment; ?>" size="120" maxlength="120" /></td>
            </tr>
        </table>
        <p class="submit"><input type="submit" class="button-primary" value="Share" /></p>
    </form>

</div>

