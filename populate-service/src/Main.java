import com.github.javafaker.Faker;
import java.time.Instant;
import java.time.LocalDateTime;
import java.time.ZoneId;
import java.util.ArrayList;
import java.util.Date;
import java.util.HashMap;
import java.util.List;
import java.util.Locale;
import java.util.Map;
import java.util.UUID;
import java.util.concurrent.TimeUnit;
import model.Exame;
import model.ExameSchema;
import model.Paciente;
import model.User;
import service.ExameSchemaService;
import service.ExameService;
import service.ICrud;
import service.PacienteService;
import service.UserService;

public class Main {

  private static int nextExameId = 1;
  private static int nextSchemaId = 1;

  // Helper para converter java.util.Date para LocalDateTime
  public static LocalDateTime convertToLocalDateTime(Date dateToConvert) {
    return Instant.ofEpochMilli(dateToConvert.getTime())
        .atZone(ZoneId.systemDefault())
        .toLocalDateTime();
  }

  public static void main(String[] args) {
    Faker faker = new Faker(new Locale("pt-BR"));

    // Inicializa os serviços
    ICrud userService = new UserService();
    ICrud pacienteService = new PacienteService();
    ICrud exameSchemaService = new ExameSchemaService();
    ICrud exameService = new ExameService();

    // Listas para armazenar Pacientes e ExameSchemas criados para vinculação
    List<Paciente> pacientesList = new ArrayList<>();
    List<ExameSchema> exameSchemaList = new ArrayList<>();

    // --- Gerar e Inserir Usuários (ex: 3 usuários) ---
    System.out.println("--- Cadastrando Usuários ---");
    for (int i = 0; i < 3; i++) {
      User user = new User();
      user.setId(UUID.randomUUID().toString());
      user.setNome(faker.name().fullName());
      user.setCpf(faker.number().digits(11));
      user.setDataNascimento(convertToLocalDateTime(faker.date().birthday(18, 65)));
      user.setSexo(faker.demographic().sex().substring(0, 1));
      user.setTelefone(faker.phoneNumber().cellPhone());
      user.setEmail(faker.internet().emailAddress());
      user.setEndereco(faker.address().fullAddress());
      user.setSenha(faker.internet().password(8, 16));
      if (faker.bool().bool()) { // RGM pode ser nulo
        user.setRGM(faker.number().digits(8));
      }
      user.setAdmin(faker.bool().bool());
      userService.inserir(user);
    }
    System.out.println("\n");

    // --- Gerar e Inserir Pacientes (ex: 5 pacientes) ---
    System.out.println("--- Cadastrando Pacientes ---");
    for (int i = 0; i < 5; i++) {
      Paciente paciente = new Paciente();
      paciente.setId(UUID.randomUUID().toString());
      paciente.setNome(faker.name().fullName());
      paciente.setCpf(faker.number().digits(11));
      paciente.setDataNascimento(convertToLocalDateTime(faker.date().birthday(1, 90)));
      paciente.setSexo(faker.demographic().sex().substring(0, 1));
      paciente.setTelefone(faker.phoneNumber().cellPhone());
      paciente.setEmail(faker.internet().emailAddress());
      paciente.setEndereco(faker.address().fullAddress());
      paciente.setRGM(faker.number().digits(8)); // Assumindo que RGM é obrigatório para Paciente

      pacienteService.inserir(paciente);
      pacientesList.add(paciente);
    }
    System.out.println("\n");

    // --- Gerar e Inserir ExameSchemas (ex: 2 schemas) ---
    System.out.println("--- Cadastrando Schemas de Exame ---");
    for (int i = 0; i < 2; i++) {
      List<Map<String, Object>> campos = new ArrayList<>();
      Map<String, Object> campo1 = new HashMap<>();
      campo1.put("nome", "Glicemia");
      campo1.put("tipo", "numerico");
      campo1.put("unidade", "mg/dL");
      campo1.put("valor_referencia", "70-99");
      campos.add(campo1);

      Map<String, Object> campo2 = new HashMap<>();
      campo2.put("nome", "Colesterol Total");
      campo2.put("tipo", "numerico");
      campo2.put("unidade", "mg/dL");
      campo2.put("valor_referencia", "<200");
      campos.add(campo2);

      if (i % 2 == 0) { // Adiciona um campo de texto a um dos schemas
        Map<String, Object> campo3 = new HashMap<>();
        campo3.put("nome", "ObservacaoClinica");
        campo3.put("tipo", "texto");
        campos.add(campo3);
      }

      ExameSchema schema = new ExameSchema(
          nextSchemaId++,
          faker.lorem().word().toUpperCase() + " Painel de Exames " + (i + 1),
          faker.lorem().sentence(10),
          campos,
          "v" + faker.number().digit() + "." + faker.number().digit(),
          new ArrayList<>() // Novo schema inicialmente não possui exames
      );
      exameSchemaService.inserir(schema);
      exameSchemaList.add(schema);
    }
    System.out.println("\n");

    // --- Gerar e Inserir Exames (ex: 10 exames) ---
    System.out.println("--- Cadastrando Exames ---");
    if (!pacientesList.isEmpty() && !exameSchemaList.isEmpty()) {
      for (int i = 0; i < 10; i++) {
        Paciente randomPaciente = pacientesList.get(faker.random().nextInt(pacientesList.size()));
        ExameSchema randomSchema =
            exameSchemaList.get(faker.random().nextInt(exameSchemaList.size()));

        Map<String, Object> dadosPreenchidos = new HashMap<>();
        if (randomSchema.getCampos() != null) {
          for (Map<String, Object> campoDef : randomSchema.getCampos()) {
            String nomeCampo = (String) campoDef.get("nome");
            String tipoCampo = (String) campoDef.get("tipo");

            if ("numerico".equals(tipoCampo)) {
              // Gera um double aleatório, garantindo que seja plausível para resultados médicos
              double value = faker.number().randomDouble(2, 40, 300);
              dadosPreenchidos.put(nomeCampo, value);
            } else if ("texto".equals(tipoCampo)) {
              dadosPreenchidos.put(nomeCampo, faker.lorem().sentence(3, 5));
            }
          }
        }

        Exame exame = new Exame(
            nextExameId++,
            randomPaciente.getId(),
            randomSchema.getId(),
            convertToLocalDateTime(faker.date().past(365, TimeUnit.DAYS)),
            // Data do exame no último ano
            dadosPreenchidos,
            faker.name().fullName(), // Responsável
            faker.lorem().sentence(), // Observações
            randomPaciente,
            randomSchema
        );
        exameService.inserir(exame);
      }
    } else {
      System.out.println(
          "Não é possível criar exames: não há pacientes ou schemas de exame cadastrados.");
    }
    System.out.println("\nCriação de dados fictícios concluída.");
  }
}