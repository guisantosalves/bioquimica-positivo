import express from "express";
import routes from "./controllers/routes.js";
import dotenv from "dotenv";
dotenv.config();

const app = express();

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
