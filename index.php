<?php

class Player
{
    public $name;
    public $coins;

    public function __construct($name, $coins)
    {
        $this->name = $name;
        $this->coins = $coins;
    }

    public function point(Player $player)
    {
        $this->coins++;
        $player->coins--;
    }

    public function bankrupt()
    {
        return $this->coins == 0;
    }

    public function bank()
    {
        return $this->coins;
    }

    //chance to win %

    public function oods(Player $player)
    {
        return round(num:$this->bank() / ($this->bank() + $player->bank()), precision:2) * 100 . '%';

    }
}

class Game
{
    protected $player_1;
    protected $player_2;
    protected $flips = 1;

    public function __construct(Player $player_1, Player $player_2)
    {
        $this->player_1 = $player_1;
        $this->player_2 = $player_2;
    }

    // flip coin

    public function flip()
    {

        return rand(0, 1) ? "орел" : "решка";
    }

    public function start()
    {

        echo <<<EOT

        Game start!

        Chance to win {$this->player_1->name}: {$this->player_1->oods($this->player_2)}
        Chance to win {$this->player_2->name}: {$this->player_2->oods($this->player_1)}

        EOT;

        $this->play();
    }

    public function play()
    {
        while (true) {

            // если орел, п1 получает монету, п2 теряет
            // если решка, п1 теряет монету, п2 получает

            if ($this->flip() == "орел") {

                $this->player_1->point($this->player_2);

            } else {

                $this->player_2->point($this->player_1);

            }

            // если у кого-то кол-во монет будет 0, то игра закончена.
            if ($this->player_1->bankrupt() || $this->player_2->bankrupt()) {
                return $this->end();
            }
            $this->flips++;
        }
    }

    public function winner(): Player
    {
        return $this->player_1->bank() > $this->player_2->bank() ? $this->player_1 : $this->player_2;
    }

    // метод окончания игры
    public function end()
    {
        // победитель тот, у кого больше монет.

        echo <<<EOT

        Game over.
        {$this->player_1->name}: {$this->player_1->bank()}
        {$this->player_2->name}: {$this->player_2->bank()}

        ________________
        Winner! : {$this->winner()->name}
        ________________

        Flips: $this->flips


        EOT;
    }
}

$game = new Game(
    new Player("Ksenia", 1000),
    new Player("Sergei", 150)
);

$game->start();
