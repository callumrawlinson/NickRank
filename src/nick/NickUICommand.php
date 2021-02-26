<?php

namespace Nickname;

use pocketmine\Player;
use pocketmine\Server;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\utils\TextFormat as C;

use jojoe77777\FormAPI\FormAPI;
use Nickname\Main;

class NickUICommand extends Command {
    
    public function __construct(Main $plugin){
        parent::__construct("nickname", "Changes your nickname and nametag.");
		$this->plugin = $plugin; 
	}

	public function execute(CommandSender $player, string $currentAlias, array $args){
		if(!$player->hasPermission("nickname.use")){
              $player->sendMessage("You do not have permission to use this command!");
                return true;
        }
	    if($player instanceof Player){
			$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
				$form = $api->createCustomForm(function (Player $p, $data){
                    if($data !== null){
				        $p->setDisplayName("$data[1]");
						$p->setNameTag("$data[1]");
						$p->sendMessage(C::GREEN . "Your nickname has been successfully changed!");
				    }
				});
				$form->setTitle(C::YELLOW . "Nickname");
				$form->addLabel("Please write your new nickname here:");
				$form->addInput("Write a nickname here!:", "Nickname");
				$form->sendToPlayer($player);
		} else {
			$player->sendMessage("You cannot use this command here!");
		}
	}
}
