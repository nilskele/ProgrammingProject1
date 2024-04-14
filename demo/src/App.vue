<template>
  <div id="app">
    <div id="container">
      <nav class="navbar navbar-light">
        <a class="navbar-brand mb-0 h1 medialab" href="#">
          <img src="/EhB-logo-transparant.png" width="60" class="d-inline-block align-top"
            alt="ehb EhB-logo-transparant" />
          <span class="medialabTitleNav">Medialab</span>
        </a>
        <nav class="navbar navbar-expand-lg navbar-light">
          <div class="navbar-nav">
            <a class="nav-item nav-link" href="/info">Info</a>
            <a class="nav-item nav-link" href="/reglement">Reglement</a>
          </div>
        </nav>
      </nav>
      <div class="welcomeDiv">
        <div class="welcome">
          <h1>
            Welcome <br />
            in het Medialab
          </h1>
          <p>
            Iets uitlenen? Doe maar gerust, als je de regels <br />
            hebt gelezen!! Meld uzelf hieronder aan of maak <br />
            een account met u school mail.
          </p>
          <div class="WelcomeButtons">
            <button class="btn btn-primary">Account aanmaken</button>
            <button class="btn btn-light">Log in</button>
          </div>
        </div>
      </div>
      <div class="Div3D">
        <img src="/3d-printer_44218.png" height="400px" alt="3d" />
      </div>
      <button class="btn btn-primary adminbtn">Admin</button>
      <div class="loginForm">
        <div class="form-group row">
          <label for="inputEmail3" class="col-sm-3 col-form-label">Email:</label>
          <div class="col-sm-9">
            <input v-model="email" @input="validateEmail" type="email" class="form-control" id="inputEmail3"
              placeholder="Email" />
            <p v-if="emailError" class="errorMelding">{{ emailError }}</p>
          </div>
        </div>

        <div class="form-group row">
          <label for="inputName" class="col-sm-3 col-form-label">Name:</label>
          <div class="col-sm-9">
            <input v-model="name" @input="validateName" type="text" class="form-control" id="inputName"
              placeholder="Name" />
            <p v-if="nameError" class="errorMelding">{{ nameError }}</p>
          </div>
        </div>
        <div class="form-group row">
          <label for="inputPassword3" class="col-sm-3 col-form-label">Password:</label>
          <div class="col-sm-9">
            <input v-model="password" @input="validatePassword" type="password" class="form-control" id="inputPassword3"
              placeholder="Password" />
            <p v-if="passwordError" class="errorMelding">{{ passwordError }}</p>
          </div>
        </div>
        <button @click="login" class="btn btn-primary justify-content-center">
          Inloggen
        </button>
        <div>
          <p v-if="loginMessage">{{ loginMessage }}</p>
        </div>
        <div class="GeenAccount">
          <p>Nog geen account?</p>
          <button class="btn btn-light">Account aanmaken</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      email: "",
      name: "",
      password: "",
      loginMessage: "",
      emailError: "",
      nameError: "",
      passwordError: "",
    };
  },
  methods: {
    login() {
      this.emailError = "";
      this.nameError = "";
      this.passwordError = "";

      // Email validation
      if (!this.email) {
        this.emailError = "Vul een geldig e-mailadres in.";
      } else if (!this.validateEmail(this.email)) {
        this.emailError = "Vul een geldig e-mailadres in.";
      }

      // Name validation
      if (!this.name) {
        this.nameError = "Vul uw naam in.";
      } else if (this.name.length < 3) {
        this.nameError = "Naam moet minstens 3 tekens lang zijn.";
      }

      // Password validation
      if (!this.password) {
        this.passwordError = "Vul een wachtwoord in.";
      } else if (this.password.length < 8) {
        this.passwordError = "Wachtwoord moet minstens 8 tekens lang zijn.";
      }

      // Check if all fields are valid
      if (this.emailError || this.nameError || this.passwordError) {
        this.loginMessage = "Vul alle velden correct in.";
      } else {
        this.loginMessage = "Login succesvol!";
        // Voer hier de login-functie uit, bijvoorbeeld een API-aanroep
      }
    },
    validateEmail(email) {
      const re = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
      return re.test(email);
    },
    validateName() {
      if (!this.name) {
        this.nameError = "Vul uw naam in.";
      } else if (this.name.length < 2) {
        this.nameError = "Naam moet minstens 2 tekens lang zijn.";
      } else {
        this.nameError = "";
      }
    },
    validatePassword() {
      if (!this.password) {
        this.passwordError = "Vul een wachtwoord in.";
      } else if (this.password.length < 8) {
        this.passwordError = "Wachtwoord moet minstens 8 tekens lang zijn.";
      } else {
        this.passwordError = "";
      }
    },
  },
};
</script>

<style scoped></style>
