import com.github.javafaker.Faker;

public class Main {
    public static void main(String[] args) {
        Faker faker = new Faker();

        System.out.println(faker.name().fullName());
        System.out.println(faker.address().city());
        System.out.println(faker.phoneNumber().phoneNumber());
        System.out.println(faker.number().digit());
    }
}