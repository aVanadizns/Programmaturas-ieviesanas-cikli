public class Fails3 {
    
    // Metode sveicienam
    public static void sveiciens() {
        System.out.println("Sveika, pasaule!");
    }
    
    // Metode skaitļu summas aprēķināšanai
    public static int summa(int a, int b) {
        return a + b;
    }

    public static void main(String[] args) {
        sveiciens();  // Izvada sveicienu
        
        int x = 5;
        int y = 10;
        System.out.println("Skaitļu " + x + " un " + y + " summa ir: " + summa(x, y));
    }
}

