using System;

class Fails4 {

    // Sveiciena metode
    static void Sveiciens() {
        Console.WriteLine("Sveika, pasaule!");
    }

    // Skaitļu summas metode
    static int Summa(int a, int b) {
        return a + b;
    }

    static void Main() {
        Sveiciens();  // Izvada sveicienu

        int x = 5;
        int y = 10;
        Console.WriteLine($"Skaitļu {x} un {y} summa ir: {Summa(x, y)}");
    }
}

