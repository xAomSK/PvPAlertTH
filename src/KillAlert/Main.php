<?php
namespace KillAlert;
use pocketmine\entity\Entity;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\block\Block;
use pocketmine\item\Item;
use pocketmine\utils\TextFormat as TT;
use pocketmine\entity\Living;
use pocketmine\math\Vector3;
use pocketmine\level\Position;


class Main extends PluginBase implements Listener {
	
	const PREFIX = TT::DARK_GRAY."".TT::RED."§bพีวีพี".TT::YELLOW.">".TT::DARK_GRAY."" . TT::WHITE."§c ";
 
    
  public function onEnable()
  {
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
   $this->getLogger()->info("KillAlerts has been enabled.");
 
           
    }
    
	public function onDeath(PlayerDeathEvent $ev){
		$player = $ev->getEntity();
		$cause = $player->getLastDamageCause();
		$ev->setDeathMessage(null);
		if($player instanceof Player){
		switch($cause === null ? EntityDamageEvent::CAUSE_CUSTOM : $cause->getCause()){
				case EntityDamageEvent::CAUSE_ENTITY_ATTACK:
					if($cause instanceof EntityDamageByEntityEvent){
						$e = $cause->getDamager();
						if($e instanceof Player){
							$this->getServer()->broadcastMessage(Main::PREFIX.$player->getNameTag()." §fถูกฆ่าตายอย่างโหดโดย§a ".$e->getNameTag()."!");
							break;
						}elseif($e instanceof Living){
							$this->getServer()->broadcastMessage(Main::PREFIX.$player->getNameTag()." §fถูกฆ่าตายอย่างโหดโดย§a ".$e->getNameTag()."!");
							break;
						}else{
							$this->getServer()->broadcastMessage(Main::PREFIX.$player->getNameTag()." §fตายห่า!");
						}
					}
					break;
				case EntityDamageEvent::CAUSE_PROJECTILE:
					if($cause instanceof EntityDamageByEntityEvent){
						$e = $cause->getDamager();
						if($e instanceof Player){
							$this->getServer()->broadcastMessage(Main::PREFIX.$player->getNameTag()." §fถูกยิงธนูตายอย่างโหดโดย§a ".$e->getNameTag()."!");
						}elseif($e instanceof Living){
							$this->getServer()->broadcastMessage(Main::PREFIX.$player->getNameTag()." §fตายโดยลูกธนูปริศนา");
							break;
						}else{
							$this->getServer()->broadcastMessage(Main::PREFIX.$player->getNameTag()." §fตายโดยลูกธนูปริศนา");
						}
					}
					break;
				case EntityDamageEvent::CAUSE_SUICIDE:
					$this->getServer()->broadcastMessage(Main::PREFIX.$player->getNameTag()." §fฆ่าตัวตาย");
					break;
				case EntityDamageEvent::CAUSE_VOID:
					$this->getServer()->broadcastMessage(Main::PREFIX.$player->getNameTag()." §fตกโลกตาย");
					break;
				case EntityDamageEvent::CAUSE_FALL:
					if($cause instanceof EntityDamageEvent){
						if($cause->getFinalDamage() > 2){
							$this->getServer()->broadcastMessage(Main::PREFIX.$player->getNameTag()." §fขาหัก ตาย");
							break;
						}
					}
					$this->getServer()->broadcastMessage(Main::PREFIX.$player->getNameTag()." §fตาย");
					break;

				case EntityDamageEvent::CAUSE_SUFFOCATION:
					$this->getServer()->broadcastMessage(Main::PREFIX.$player->getNameTag()." §fติดบล๊อคตาย");
					break;

				case EntityDamageEvent::CAUSE_LAVA:
					$this->getServer()->broadcastMessage(Main::PREFIX.$player->getNameTag()." §fจม §6ลาวา§f ตาย");
					break;

				case EntityDamageEvent::CAUSE_FIRE:
					$this->getServer()->broadcastMessage(Main::PREFIX.$player->getNameTag()." §fโดน §cไฟไหม้§c ครอบตัวตาย");
					break;

				case EntityDamageEvent::CAUSE_FIRE_TICK:
					$this->getServer()->broadcastMessage(Main::PREFIX.$player->getNameTag()." §fโดน §cไฟไหม้§c ครอบตัวตาย");
					break;

				case EntityDamageEvent::CAUSE_DROWNING:
					$this->getServer()->broadcastMessage(Main::PREFIX.$player->getNameTag()." §fตายเพราะ ว่าย§bน่ำ§f ไม่เป็น");
					break;

				case EntityDamageEvent::CAUSE_CONTACT:
					if($cause instanceof EntityDamageByBlockEvent){
						if($cause->getDamager()->getId() === Block::CACTUS){
							$this->getServer()->broadcastMessage(Main::PREFIX.$player->getNameTag()." §fถูกหนามทิ่มตาย");
						}
					}
					break;

				case EntityDamageEvent::CAUSE_BLOCK_EXPLOSION:
				case EntityDamageEvent::CAUSE_ENTITY_EXPLOSION:
					if($cause instanceof EntityDamageByEntityEvent){
						$e = $cause->getDamager();
						if($e instanceof Player){
							$this->getServer()->broadcastMessage(Main::PREFIX.$player->getNameTag()." §fโดนระเบิดโดย§a ".$e->getNameTag()."!");
						}elseif($e instanceof Living){
							$this->getServer()->broadcastMessage(Main::PREFIX.$player->getNameTag()." §fระเบิดตัวเองตาย");
							break;
						}
					}else{
						$this->getServer()->broadcastMessage(Main::PREFIX.$player->getNameTag()." §fตาย");
					}
					break;

				case EntityDamageEvent::CAUSE_MAGIC:
					$this->getServer()->broadcastMessage(Main::PREFIX.$player->getNameTag()." §fตาย");
					break;

				case EntityDamageEvent::CAUSE_CUSTOM:
					$this->getServer()->broadcastMessageTag(Main::PREFIX.$player->getName()." §fตาย");
					break;
		}
	}
 }
}
