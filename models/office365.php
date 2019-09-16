<?php
    class Office365Model{
        //GET method for REST API
        public function ews_get($odata_command)
        {
            //$URL = 'https://outlook.office.com/api/v1.0/Me';  //doesn't work anymore
            $URL = 'https://outlook.office365.com/api/v1.0/Me'; //Thanks Venkat :)

            //concatenation of the command url
            $URL .= $odata_command;

            $options = array(
                CURLOPT_RETURNTRANSFER => true,             // return web page content
                CURLOPT_FOLLOWLOCATION => true,             // follow redirections
                CURLOPT_AUTOREFERER    => true,             // set referer on redirections
                CURLOPT_CONNECTTIMEOUT => 60,               // timeout on connect
                CURLOPT_TIMEOUT        => 60,               // timeout on response
                CURLOPT_SSL_VERIFYPEER => false,            // Disabled SSL Cert checks
                CURLOPT_USERPWD        => EWS_USERNAME . ':' . EWS_PASSWORD, //see constants
                CURLOPT_HTTPAUTH       => CURLAUTH_BASIC,   //Basic authentication 
            );

            $ch = curl_init($URL);

            curl_setopt_array( $ch, $options );

            $objResult = json_decode(curl_exec( $ch ));

            curl_close( $ch );

            return $objResult;
        }


        //Return a folder information for an Inbox subfolder named $displayName
        public function getInboxChildFolderByDisplayName($displayName)
        {
            //NOTE DEV: The $ sign is not correctly interpreted in a double quote string in php
            //NOTE DEV: The ' in the url was replaced by %27
            $results = ews_get('/Folders(\'Inbox\')/ChildFolders?$filter=DisplayName%20eq%20%27' . $displayName . '%27');

            $arrFolderInfo = $results->value;

            //return the first folder info
            return $arrFolderInfo[0];
        }


        //Get messages from the folder id
        public function getMessagesFromFolderId($folderId = 'Inbox')
        {
            $objResult = ews_get("/Folders('" . $folderId . "')/Messages");

            return $objResult->value;
        }
    }
?>