<?php
class PrliUrlUtils {

  function get_title($url, $slug='')
  {
    // Grab the title tag
    $title = $this->url_grab_title($url);
    
    if(!$title)
      return $slug;
    
    return $title;
  }
  
  /*
    Go out to the web and see if the url resolves
  */
  function valid_url($url)
  {
    $valid = false;

    $remote_page = $this->read_remote_file($url,1);
    if($remote_page and !empty($remote_page))
      $valid = true;

    return $valid;
  }
  
  function url_grab_title($url)
  {
    $title = false;

    $remote_page = $this->read_remote_file($url,10);

    // Look for <title>(.*?)</title> in the text
    if($remote_page and preg_match('#<title>[\s\n\r]*?(.*?)[\s\n\r]*?</title>#im', $remote_page, $matches))
      $title = trim($matches[1]);
    
    return $title;
  }

  /**
  * Sends http request ensuring the request will fail before $timeout seconds
  * gotta use a socket connection because some hosting setups don't allow fopen.
  * Supports SSL sites as well as 301, 302 & 307 redirects
  * Returns the response content (no header, trimmed)
  * @param string $url
  * @param string $num_chunks Set to 0 if you want to read the full file
  * @param string $chunk_size In bytes
  * @param int $timeout
  * @return string|false false if request failed
  */
  function read_remote_file($url, $num_chunks=0, $headers='', $params='', $chunk_size=1024, $timeout=30 )
  {
    $purl = @parse_url($url);

    $sock_host   = $purl['host'];
    $sock_port   = 80;
    $sock_scheme = $purl['scheme'];

    $req_host    = $purl['host'];
    $req_path    = $purl['path'];

    if(empty($req_path))
      $req_path = "/";

    if($sock_scheme == 'https')
    {
      $sock_port = 443;
      $sock_host = "ssl://{$sock_host}";
    }

    $fp = fsockopen($sock_host, $sock_port, $errno, $errstr, $timeout);
    $contents = '';
    $header = '';

    if (!$fp)
      return false;
    else
    {
      // Send get request
      $request = "GET {$req_path}{$params} HTTP/1.1\r\n";
      $request .= "Host: {$req_host}\r\n";
      $request .= $headers;
      $request .= "Connection: Close\r\n\r\n";
      fwrite($fp, $request);

      // Read response
      $head_end_found = false;
      $buffer = '';
      for($i = 0; !feof($fp); $i++)
      {
        if($num_chunks > 0 and $i >= $num_chunks)
          break;

        $out = fread($fp,$chunk_size);
        if($head_end_found)
          $contents .= $out;
        else
        {
          $buffer .= $out;
          $head_end = strpos($buffer, "\r\n\r\n");
          if($head_end !== false)
          {
            $head_end_found = true;
            $contents .= substr($buffer, ($head_end + 4));
            $header .= substr($buffer, 0, $head_end);
            // Follow HTTP redirects
            if(preg_match("#http/1\.1 301#i",$header) or
               preg_match("#http/1\.1 302#i",$header) or
               preg_match("#http/1\.1 307#i",$header))
            {
              preg_match("#^Location:(.*?)$#im",$header,$matches);
              return $this->read_remote_file(trim($matches[1]));
            }
          }
        }
      }
      fclose($fp);
    }

    if(empty($contents))
      return false;
    else
      return trim($contents);
  }
}
?>
