import express from "express";
import morgan from "morgan";
import routes from "./controllers/routes.js";
import dotenv from "dotenv";
dotenv.config();

const app = express();

app.use(morgan("dev")); // Middleware para logar as requisições

// Middlewares para processar o corpo da requisição
app.use(express.json()); // Para processar corpos de requisição JSON
app.use(express.urlencoded({ extended: true })); // Para processar corpos de requisição URL-encoded

// routing
app.use(routes);

app.listen(process.env.PORT, (err) => {
  if (!err) {
    console.log(
      "Server is Successfully running, and app is listening on port " +
        process.env.PORT
    );
  } else {
    console.log("Error listening port " + process.env.PORT);
  }
});
