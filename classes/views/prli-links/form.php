<table class="form-table">
  <tr class="form-field">
    <td width="75px" valign="top">Target URL*: </td>
    <td><textarea style="height: 50px;" name="url"><?php echo $values['url']; ?></textarea>
    <br/>
      <span class="description">Enter the URL you want to mask and track. Don't forget to start your url with <code>http://</code> or <code>https://</code>. Example: <code>http://www.yoururl.com</code></span></td>
  </tr>
  <tr>
    <td valign="top">Pretty Link*: </td>
    <td><strong><?php echo $prli_blogurl; ?></strong>/<input type="text" name="slug" value="<?php echo $values['slug']; ?>" size="25">
    <br/>
    <span class="description">Enter the slug (word trailing your main URL) that will form your pretty link and redirect to the URL above.</span></td>
  </tr>
  <tr class="form-field">
    <td width="75px" valign="top">Title: </td>
    <td><input type="text" name="name" size="75" value="<?php echo $values['name']; ?>" />
    <br/>
      <span class="description">This will act as the title of your Pretty Link. If a name is not entered here then the slug name will be used.</span></td>
  </tr>
  <tr class="form-field">
    <td valign="top">Description: </td>
    <td><textarea style="height: 100px;" name="description"><?php echo $values['description']; ?></textarea>
    <br/>
    <span class="description">A Description of this link.</span></td>
  </tr>
  <tr class="form-field">
    <td colspan="2">
      <span>Group:&nbsp;</span>
      <select name="group_id">
        <option>None</option>
        <?php
          foreach($values['groups'] as $group)
          {
        ?>
            <option value="<?php echo $group['id']; ?>"<?php echo $group['value']; ?>><?php echo $group['name']; ?>&nbsp;</option>
        <?php
          }
        ?>
      </select>
      <br/>
      <span class="description">Select a group for this link.</span>
    </td>
  </tr>
</table>
<h3><a class="options-table-toggle">Link Options <span class="expand-options" style="display: none;">[+]</span><span class="collapse-options">[-]</span></a> <span class="expand-collapse" style="display: none"><a class="expand-all" title="Show all option instructions.">[?]</a><a class="collapse-all" title="Hide all option instructions." style="display: none;">[?]</a></span></h3>
<table class="options-table">
  <tr>
    <td valign="top" width="50%">
      <h3>Display Options</h3>
      <div class="pane">
        <input type="checkbox" name="use_prettybar" <?php echo $values['use_prettybar']; ?>/>&nbsp; Show Pretty Bar <a class="toggle">[?]</a>
        <div class="toggle_pane description">Select this option if you want to show the Pretty Bar at the top of the page when redirecting to the Target URL.</div>
        <br/>
        <input type="checkbox" name="use_ultra_cloak" <?php echo $values['use_ultra_cloak']; ?>/>&nbsp; Ultra Cloak this Link <a class="toggle">[?]</a>
        <div class="toggle_pane description">When checked, the Target URL will be not be visible even after the redirection. This way, if a Target URL doesn't redirect to a URL you want to show then this will mask it.</div>
      </div>
      <br/>
      <h3>Tracking Options</h3>
      <div class="pane">
        <input type="checkbox" name="track_me" <?php echo $values['track_me']; ?>/>&nbsp; Track this Link <a class="toggle">[?]</a>
        <div class="toggle_pane description">De-select this option if you don't want this link tracked. If de-selected, this link will still redirect to the target URL but hits on it won't be recorded in the database.</div>
        <br/>
        <input type="checkbox" name="track_as_img" <?php echo $values['track_as_img']; ?>/>&nbsp; Track as a Pixel <a class="toggle">[?]</a>
        <div class="toggle_pane description">Select this option if you want this link to behave as a tracking pixel instead of as a link. This option is useful if you want to track the number of times a page or email is opened. If you place your Pretty Link inside an img tag on the page (Example: <code>&lt;img src="<?php echo $prli_blogurl . "/yourslug"; ?>" /&gt;</code>) then the page load will be tracked as a click and then displayed. Note: If this option is selected your Target URL will simply be ignored if there's a value in it.</div>
      </div>
      <br/>
      <h3>SEO Options</h3>
      <div class="pane">
        <input type="checkbox" name="nofollow" <?php echo $values['nofollow']; ?>/>&nbsp; 'Nofollow' this Link <a class="toggle">[?]</a>
        <div class="toggle_pane description">Select this if you want to add a nofollow code to this link. A nofollow will prevent reputable spiders and robots from following or indexing this link.</div>
      </div>
    </td>
    <td valign="top" width="50%">
      <h3>Redirect Type:</h3>
      <ul style="list-style-type: none" class="pane">
        <li>
          <input type="radio" name="redirect_type" value="307" <?php echo $values['redirect_type']['307']; ?>/>&nbsp;Temporary Redirect (307) <a class="toggle">[?]</a>
          <div class="toggle_pane description">This is the best option if you're planning on changing your Target URL and want accurate reporting for this link.</div>
        </li>
        <li>
          <input type="radio" name="redirect_type" value="301" <?php echo $values['redirect_type']['301']; ?> />&nbsp;Permanent Redirect (301) <a class="toggle">[?]</a>
          <div class="toggle_pane description">This is the best option if you're <strong>NOT</strong> planning on changing your Target URL. Traditionally this option is considered to be the best approach to use for your SEO/SEM efforts but since Pretty Link uses your domain name either way this notion isn't necessarily true for Pretty Links. Also, this option may not give you accurate reporting since proxy and caching servers may go directly to your Target URL once it's cached.</div>
        </li>
      </ul>
      <br/>
      <h3>Group Options</h3>
      <div class="pane">
        Group Listing Order:&nbsp;<input type="text" name="gorder" value="<?php echo $values['gorder']; ?>" size="10"> <a class="toggle">[?]</a>
        <div class="toggle_pane description">You can use this to determine the order that your link show up in the group it's in. The group will default to alphabetic order -- but this will override that default behavior. I also realize this isn't the easiest way for you to re-order links but we'll get a better way in the future.</div>
      </div>
      <br/>
      <a name="param_forwarding_pos" height="0"></a>
      <h3>Parameter Forwarding</h3>
      <ul style="list-style-type: none" class="pane">
        <li>
          <input type="radio" name="param_forwarding" value="off" <?php echo $values['param_forwarding']['off']; ?>/>&nbsp; Forward Parameters Off <a class="toggle">[?]</a>
          <div class="toggle_pane description">You may want to leave this option off if you don't need to forward any parameters on to your Target URL.</div>
        </li>
        <li>
          <input type="radio" name="param_forwarding" value="on" <?php echo $values['param_forwarding']['on']; ?> />&nbsp;Standard Parameter Forwarding <a class="toggle">[?]</a>
          <div class="toggle_pane description">Select this option if you want to forward parameters through your pretty link to your Target URL. This will allow you to pass parameters in the standard syntax for example the pretty link <code>http://yoururl.com/coollink?product_id=4&sku=5441</code> will forward to the target URL and append the same parameters like so: <code>http://anotherurl.com?product_id=4&sku=5441</code>.</div>
        </li>
        <li>
          <input type="radio" name="param_forwarding" value="custom" <?php echo $values['param_forwarding']['custom']; ?> />&nbsp;Custom Parameter Forwarding&nbsp;&nbsp;<input type="text" name="param_struct" value="<?php echo $values['param_struct'] ?>" size="25"/> <a class="toggle">[?]</a>
          <div class="toggle_pane description">Select this option if you want to forward parameters through your Pretty Link to your Target URL and write the parameters in a custom format. For example, say I wanted to to have my links look like this: <code>http://yourdomain.com/products/14/4</code> and I wanted this to forward to <code>http://anotherurl.com?product_id=14&dock=4</code> you'd just select this option and enter the following string into the text field <code>/products/%product_id%/%dock%</code>. This will tell Pretty Link where each variable will be located in the URL and what each variable name is.</div>
        </li>
      </ul>
    </td>
  </tr>
</table>
<?php
  // Add stuff to the form here
  do_action('prli_link_fields',$id);
?>
