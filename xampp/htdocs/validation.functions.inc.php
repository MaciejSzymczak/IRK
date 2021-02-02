<?php
function valid_email($email)
{
    // First, we check that there's one @ symbol, and that the lengths are right
    if (!preg_match("/^[^@]{1,64}@[^@]{1,255}$/", $email))
    {
        // Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
        return false;
    }
    // Split it into sections to make life easier
    $email_array = explode("@", $email);
    $local_array = explode(".", $email_array[0]);
    for ($i = 0; $i < sizeof($local_array); $i++)
    {
        if (!preg_match("/^(([A-Za-z0-9!#$%&#038;'*+\/=?^_`{|}~-][A-Za-z0-9!#$%&#038;'*+\/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$/",
            $local_array[$i]))
        {
            return false;
        }
    }
    if (!preg_match("^\[?[0-9\.]+\]?$", $email_array[1]))
    { // Check if domain is IP. If not, it should be valid domain name
        $domain_array = explode(".", $email_array[1]);
        if (sizeof($domain_array) < 2)
        {
            return false; // Not enough parts to domain
        }
        for ($i = 0; $i < sizeof($domain_array); $i++)
        {
            if (!preg_match("/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$/", $domain_array[$i]))
            {
                return false;
            }
        }
    }
    return true;
}

function valid_password($pass, $minlength = 8)
{
    $pass = trim($pass);
    if (empty($pass))
    {
        return false;
    }
    if (strlen($pass) < $minlength)
    {
        return false;
    }	
	return true;
}

function valid_username($username,$sex="?")
{
 return valid_email($username);
 /*
 if ($username==null) return false;
 $wynik = strlen($username);
 //if (!($wynik=='11')) return false;
 if ($username[9] % 2 and $sex=="K") return false;
 else if (!$username[9] % 2 and $sex=="M") return false;
 $w=array(1,3,7,9);
 for ($i=0;$i<=9;$i++)
   $wk=($wk+$username[$i]*$w[$i % 4]) % 10;
 $k = (10-$wk) % 10;
 if ($username[10]==$k) return true;
 else return false;
 */
 }

?>