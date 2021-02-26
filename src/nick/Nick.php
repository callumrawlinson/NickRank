<?php

namespace nick;

use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\entity\{Effect, EffectInstance, Entity};
use pocketmine\Player;
use UIAPI\{Form, ModalForm, SimpleForm, CustomForm};
use UIS\KickUI;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\CommandExecutor;
use pocketmine\command\ConsoleCommandSender;

class Nick extends PluginBase implements Listener {
	
    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);    
        $this->getLogger()->info(TextFormat::GREEN . "Nick Activate By Callum");
	$this->getServer()->getCommandMap()->register("nickname", new NickUICommand($this));
    }
    public function onDisable() {
        $this->getLogger()->info(TextFormat::RED . "Nick Deactivate By Callum");
    }
    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
        switch($cmd->getName()){                    
            case "nick":
                if ($sender->hasPermission("nick.command")){
                     $this->Menu($sender);
                }else{     
                     $sender->sendMessage(TextFormat::RED . "§You do not have permission to use the nickUI");
                     return true;
                }     
            break;         
            
         }  
        return true;                         
    }
   
    public function Menu($sender){ 
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createSimpleForm(function (Player $sender, int $data = null){
            $result = $data;
            if($result === null){
			return true;
            }             
            switch($result){
                case 0:
                    $this->getServer()->dispatchCommand($sender, "nick");
                break;   
               case 1:
                    $this->getServer()->dispatchCommand($sender, "rank");
                break;   
                  }
        });
        $form->setTitle("§f§lNickUI");
        $form->setContent("§7NickUI with Rank Changer §b@CallumRawlinson");
        $form->addButton("§l§eChange Nickname\n§r§0Select",0,"textures/ui/conduit_power_effect");
        $form->addButton("§l§bChange Rank\n§r§0Select",1,"textures/ui/invisibility_effect");        
        $form->sendToPlayer($sender);
            return $form;
  
