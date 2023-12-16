import React, { Component } from "react";
import axios from "axios";

class SignInCliente extends Component {
  constructor() {
    super();
    this.state = {
      username: "",
      email: "",
      password: "",
    }
  }
  
    handleInputChange = (event) => {
      this.setState({ [event.target.name]: event.target.value });
    };
  
    handleSubmit = (event) => {
      event.preventDefault();
      const { username, password, email } = this.state;
  
      axios
        .post("http://localhost:8888/insert_cliente.php", { username, password, email })
    };

    render()
    {
      const { username, password, email } = this.state;
      return (
        <div className="container-fluid d-flex justify-content-center">
        <form className="form-group col-4" onSubmit={this.handleSubmit}>
        <h1 className="mt-4 d-flex justify-content-center">INSERT</h1>
          <div>
            <label htmlFor="username">Inserisci un nome utente:</label>
            <input type="text" className="form-control" name="username" id="username" placeholder="Nome utente" autoComplete="on" value={username} onChange={this.handleInputChange} />
          </div>
          <div>
            <label htmlFor="email">Inserisci una email:</label>
            <input type="email"  className="form-control" name="email" id="email" placeholder="Email" autoComplete="on" value={email} onChange={this.handleInputChange} />
          </div>
          <div>
            <label htmlFor="password">Inserisci una password:</label>
            <input type="password" className="form-control" name="password" id="password" autoComplete="off" value={password} onChange={this.handleInputChange} />
          </div>
          <button type="submit" className="btn btn-primary btn-lg w-100 mt-3">Invio</button>
        </form>
        </div>
      );
    }
  };
  
  export default SignInCliente;