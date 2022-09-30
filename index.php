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

    // подбросить монету

    public function flip()
    {

        return rand(0, 1) ? "орел" : "решка";
    }

    public function start()
    {
        while (true) {

            // если орел, п1 получает монету, п2 теряет
            // если решка, п1 теряет монету, п2 получает

            if ($this->flip() == "орел") {

                $this->player_1->point($this->player_2);

            } else {

                $this->player_1->point($this->player_1);

            }

            // если у кого-то кол-во монет будет 0, то игра закончена.
            if ($this->player_1->coins == 0 || $this->player_2->coins == 0) {
                return $this->end();
            }
            $this->flips++;
        }
    }

    public function winner()
    {
        if ($this->player_1->coins > $this->player_2->coins) {
            return $this->player_1;
        } else {
            return $this->player_2;
        }
    }

    // метод окончания игры
    public function end()
    {
        // победитель тот, у кого больше монет.

        echo <<<EOT

        Game over.
        {$this->player_1->name}: {$this->player_1->coins}
        {$this->player_2->name}: {$this->player_2->coins}

        Winner: {$this->winner()->name}

        Flips: $this->flips


        EOT;
    }
}

$game = new Game(
    new Player("Ksenia", 100),
    new Player("Sergei", 100)
);

$game->start();
