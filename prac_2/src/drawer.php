<?php
class Drawer
{
    // Кодирование фигуры состоит из нескольких параметров: форма,
    // цвет, размеры ограничивающего прямоугольника примитива. 

    // Параметры кодируются в 32-битное целое число (int) следующим образом:

    // Форма фигуры задается 2-мя младшими битами. Их десятичное представление:
    // 0 - круг, 1 - квадрат, 2 - треугольник, 3 - ромб.

    //  Цвет задается 3-мя следующими битами. Их десятичное представление:
    // 0 - красный, 1 - синий, 2 - зеленый, 3 - желтый, 4 - черный, 5 - белый.

    // Ширина и высота ограничивающего прямоугольника задаются 27-ми
    // смещенными битами. Их десятичное представление: от 0 до 134217727.
    // Значение 0 соответствует ширине 1px, 1 - 2px, 2 - 3px и т.д.

    // Для круга, квадрата и треугольника ширина и высота совпадают.
    // Для ромба ширина высота отличаются в 2 раза.

    // Пример кодирования фигуры: круг синего цвета с диаметром 100px.
    // 0b00000000000000000000000000000000 - форма круг
    // 0b00000000000000000000000000000100 - цвет синий
    // 0b00000000000000000000110010000000 - диаметр 100px  
    // (100 - 1100100, но смещаем на 5 бит влево, т.к. 5 бит занято формой и цветом. Получаем 110010000000
    // 0b00000000000000000000110010000100 - итоговое значение = 3204


    protected int $code;

    public function __construct(int $code)
    {
        $this->code = $code;
    }

    private function decode(): array
    {
        $shape = $this->code & 0b11;
        $color = ($this->code >> 2) & 0b111;
        $size = ($this->code >> 5) & 0b111111111111111111111111111;

        echo "Форма: $shape, Цвет: $color, Размер: $size" . PHP_EOL;

        return [$shape, $color, $size];
    }


    public function draw(): void
    {
        $decoded = $this->decode();
        $shape = $decoded[0];
        $color = $decoded[1];
        $size = $decoded[2];

        $color = $this->getColor($color);

        switch ($shape) {
            case 0:
                $this->drawCircle($color, $size);
                break;
            case 1:
                $this->drawSquare($color, $size);
                break;
            case 2:
                $this->drawTriangle($color, $size);
                break;
            case 3:
                $this->drawRhombus($color, $size);
                break;
        }
    }


    private function drawCircle(string $color, int $size): void
    {
        $whsize = $size * 2;
        echo "<svg height=\"$whsize \" width=\"$whsize\">
        <circle cx=\"$size\" cy=\"$size\" r=\"$size\" stroke=\"$color\" stroke-width=\"1\" fill=\"$color\" />
        </svg>" . PHP_EOL;
    }

    private function drawSquare(string $color, int $size): void
    {
        echo "<svg height=\"$size\" width=\"$size\">
        <rect x=\"0\" y=\"0\" width=\"$size\" height=\"$size\" style=\"fill:$color;stroke-width:1;stroke:$color\" />
        </svg>" . PHP_EOL;
    }

    private function drawTriangle(string $color, int $size): void
    {
        echo "<svg height=\"$size\" width=\"$size\">
        <polygon points=\"0,0 $size,$size 0,$size\" style=\"fill:$color;stroke:$color;stroke-width:1\" />
        </svg>" . PHP_EOL;
    }

    private function drawRhombus(string $color, int $size): void
    {
        $whsize = $size * 2;
        echo "<svg height=\"$whsize\" width=\"$whsize\">
        <polygon points=\"0,$size $size,0 $whsize,$size $size,$whsize\" style=\"fill:$color;stroke:$color;stroke-width:1\" />
        </svg>" . PHP_EOL;
    }

    private function getColor(int $color): string
    {
        switch ($color) {
            case 0:
                return 'red';
            case 1:
                return 'blue';
            case 2:
                return 'green';
            case 3:
                return 'yellow';
            case 4:
                return 'black';
            case 5:
                return 'white';
        }
    }
}
