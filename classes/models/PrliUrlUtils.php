<?
class PrliUrlUtils {

  function get_title($url, $slug='')
  {
    $fp = @fopen($url, 'r');
    if (!$fp)
      return $slug;
  
    // Grab the title tag
    $title = $this->url_grab_title($fp);
    
    fclose($fp);

    // No <title> tag
    if (!$title)
      return $slug;
    
    return $title;
  }
  
  /*
    Go out to the web and see if the url resolves
  */
  function valid_url($url)
  {
    $valid = false;

    $fp = @fopen($url, 'r');
    if ($fp)
      $valid = true;
    fclose($fp);

    return $valid;
  }
  
  function url_grab_title($fp, $num_chunks = 8)
  {
    // How many bytes to grab in one chunk.
    // Most sites seem to have <title> within 1024
    $chunk_size = 1024;
    $title = false;

    for($i = 0; $i < $num_chunks; $i++)
    {
      $chunk = fread($fp, $chunk_size);
      $chunk = preg_replace("#(\n|\r)#", '', $chunk);
    
      // Look for <title>(.*?)</title> in the text
      if (preg_match('#<title>(.*?)</title>#i', $chunk, $matches))
      {
        $title = $matches[1];
        break;
      }
    }
    
    return $title;
  }
}
?>
