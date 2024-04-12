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
            <input v-model="email" type="email" class="form-control" id="inputEmail3" placeholder="Email" />
          </div>
        </div>
        <div class="form-group row">
          <label for="inputName3" class="col-sm-3 col-form-label">Naam:</label>
          <div class="col-sm-9">
            <input v-model="name" type="text" class="form-control" id="inputName3" placeholder="Naam" />
          </div>
        </div>
        <div class="form-group row">
          <label for="inputPassword3" class="col-sm-3 col-form-label">password:</label>
          <div class="col-sm-9">
            <input v-model="password" type="password" class="form-control" id="inputPassword3" placeholder="Passwoord" />
          </div>
        </div>
        <button @click="login" class="btn btn-primary justify-content-center">Inloggen</button>
        <div>
          <p v-if="loginMessage">{{ loginMessage }}</p>
        </div>

      </div>
      <div class="GeenAccount">
        <p>Nog geen account? =</p>
        <button class="btn btn-light">Account aanmaken</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      email: '',
      name: '',
      password: '',
      loginMessage: ''
    };
  },
  methods: {
    login() {
      if (this.email && this.name && this.password) {
        this.loginMessage = 'Login succesvol!';
      } else {
        this.loginMessage = 'Vul alle velden in.';
      }
    }
  }
};
</script>

<style scoped></style>
