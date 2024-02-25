<?php

use MX\MX_Controller;

class levelup extends MX_Controller {
    
    private $characters;
    private $total;

    public function __construct() {
        parent::__construct();

        $this->user->userArea();

        //Load the Config
        $this->load->config( 'levelup' );

        //Load the models
        $this->load->model( 'Levelup_Model' );

    }

    private function init() {
        $this->characters = $this->user->getCharacters( $this->user->getId() );

        foreach ( $this->characters as $realm_key => $realm ) {
            if ( is_array( $realm['characters'] ) ) {
                foreach ( $realm['characters'] as $character_key => $character ) {
                    $this->characters[$realm_key]['characters'][$character_key]['avatar'] = $this->realms->formatAvatarPath( $character );
                }
            }
        }

        $this->total = 0;

        foreach ( $this->characters as $realm ) {
            if ( $realm['characters'] ) {
                $this->total += count( $realm['characters'] );
            }
        }
    }

    public function index() {

        $this->init();

        $this->template->setTitle( "Character LevelUp" );

        clientLang( "cant_afford", "levelup" );
        clientLang( "purchase", "levelup" );
        clientLang( "want_to_buy", "levelup" );
        clientLang( "processing", "levelup" );

        clientLang( "no_realm_selected", "levelup" );
        clientLang( "no_char_selected", "levelup" );

        //Load the content
        $content_data = array(
            "characters" => $this->characters,
            "url" => $this->template->page_url,
            "total" => $this->total,
            "dp" => $this->user->getDp(),
            "firstRealm"=> $this->Levelup_Model->GetRealmLastID() ,
            "service_cost" => $this->config->item( "price" ),
            'maxlevel' => $this->config->item( "max_level" ),
            'description' => $this->config->item( "description" ),
            'prices' => $this->config->item( "price_lvl" ),
        );

        $page_content = $this->template->loadPage( "levelup.tpl", $content_data );

        //Load the page
        $page_data = array(
            "module" => "default",
            "headline" => "Character LevelUp",
            "content" => $page_content
        );

        $page = $this->template->loadPage( "page.tpl", $page_data );

        $this->template->view( $page, "modules/levelup/css/levelup.css", "modules/levelup/js/levelup.js" );
    }

    /**
    * Submit method
    */

    public function submit() {

        $characterGuid = $this->input->post( 'guid' );
        $realmId = $this->input->post( 'realm' );
        $price = $this->input->post( 'price' );

        $prices = $this->config->item( "price_lvl" );

        $levelup = array_search( $price, $prices );

        // Make sure the realm actually supports console commands
        if ( !$this->realms->getRealm( $realmId )->getEmulator()->hasConsole() ) {
            die( lang( "not_support", "levelup" ) );
        }

        if ( $characterGuid && $realmId ) {

            $realmConnection = $this->realms->getRealm( $realmId )->getCharacters();
            $realmConnection->connect();

            // Make sure the character exists
            if ( !$realmConnection->characterExists( $characterGuid ) ) {
                die( lang( "character_does_not_exist", "levelup" ) );
            }

            // Make sure the character belongs to this account
            if ( !$realmConnection->characterBelongsToAccount( $characterGuid, $this->user->getId() ) ) {
                die( lang( "character_does_not_belong_account", "levelup" ) );
            }

            //Get the character name
            $CharacterName = $realmConnection->getNameByGuid( $characterGuid );

            //Make sure we've got the name
                if (!$CharacterName) {
                    die(lang("unable_resolve_character_name", "levelup"));
                }
                
                  //Get the character  is online?
                    $isOnline =   $realmConnection->isOnline($characterGuid);  
            
               ///Need Ok? Onwer Change 
            
               //    if ($isOnline) {
                //    die(lang("character_is_online", "levelup"));
               //   }
                    
                //Check if the user can afford the service
                if ($this->user->getDp() >= $price ) {
                    
                 
                            //Get the command for this emulator
                             $command = $this->GetCommand($realmId, $CharacterName,$levelup);

                              if (!$command) {
                               die(lang("no_camamand", "levelup"));
                         }

                    //Execute the command
                    $this->realms->getRealm($realmId)->getEmulator()->sendCommand($command);
                    
                   
                    //Update Donation Points
                    if ($price > 0) {
                        $this->user->setDp($this->user->getDp() - $price);
                    }

                    //Successful
                    die(lang("successfully","levelup"));
                    
                } else {
                    die(lang("dont_enough_Donation_Points", "levelup"));
                }
         
        } else {
            die(lang("no_selected_service", "levelup"));
        }
    }

    private function GetCommand($realmId, $CharacterName,$level) {
        
                return $this->GetLevelUpCommand($realmId, $CharacterName,$level);
    }
    
    private function GetLevelUpCommand($realmId, $CharacterName,$level)
    {
        //$level = $this->config->item("max_level");
        
        switch ($this->getEmulatorString($realmId)) {
                
            case 'vmangos':
            case 'mangos_one_two':
            case 'mangos_three':
            case 'mangos_zero':
            case 'cmangos':     
            case 'azerothcore':
            case 'skyfire':             
            case 'trinity':
            case 'trinity_sl':
            case 'trinity_legion':
            case 'trinity_cata':
            case 'trinity_df':
            case 'trinity_wotlkclassic':
                return '.char level ' . $CharacterName . ' ' . $level;
        }

        return false;
    }
    
    

    private function getEmulatorString($realmId)
    {
        return $this->realms->getRealm($realmId)->getConfig('emulator' );
        }

    }
