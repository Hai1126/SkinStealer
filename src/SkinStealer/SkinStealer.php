<?php

namespace SkinStealer;

use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use FormAPI\Form;
use FormAPI\CustomForm;

class SkinStealer extends PluginBase {

    public $players = [];

	public function onEnable() {
		$this->getLogger()->info("§aEnabled By DRAGKILLS and SeakHai");
	}
	
	public function onCommand(CommandSender $sender, Command $command, String $label, array $args): bool {
		if($sender instanceof Player) {
			$this->Skin($sender);
			return true;
		}
	}

	public function Skin($p)
        {
        $list = [];
        foreach($this->getServer()->getOnlinePlayers() as $player){
            $list[] = $player->getName();
        }
        $this->players[$p->getName()] = $list;
        $form = new CustomForm(function (Player $p,array $data = null){
            if($data == null){
                return true;
            }
            $dataSelected = $this->getServer()->getPlayer($this->players[$p->getName()][$data[1]]);
            $otherSkin = $dataSelected->getSkin();
            $p->sendMessage("§aYou Stole {$dataSelected->getName()} Skin!");
            $p->setSkin($otherSkin);
            $p->sendSkin();
            $p->despawnFromAll();
            $p->spawnToAll();
        });
        $form->setTitle("§a§lSkinStealer");
        $form->addLabel("§l§aSelect Player Skin");
        $form->addDropdown("",$this->players[$p->getName()]);
        $form->sendToPlayer($p);
        return $form;
    }

}
