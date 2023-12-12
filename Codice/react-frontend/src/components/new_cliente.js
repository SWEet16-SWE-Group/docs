import React, { useState } from "react";
import axios from "axios";

const SignInCliente = () => {
    const [formData, setFormData] = useState({
      username: "",
      email: "",
      password: "",
    });
  
    const handleInputChange = (event) => {
      const { name, value } = event.target;
      setFormData({ ...formData, [name]: value });
    };
  
    const handleSubmit = (event) => {
      event.preventDefault();
  
      axios
        .post("http://localhost:8888/insert_cliente.php", formData)
        .then((response) => {
          console.log(response);
        })
        .catch((error) => {
          console.log(error);
        });
    };

      return (
        <div className="container-fluid d-flex justify-content-center">
        <form className="form-group" onSubmit={handleSubmit}>
        <h1 className="mt-4 d-flex justify-content-center">INSERT</h1>
          <div>
            <label htmlFor="username">Inserisci un nome utente:</label>
            <input type="text" className="form-control" name="username" id="username" placeholder="Nome utente" autoComplete="on" value={formData.username} onChange={handleInputChange} />
          </div>
          <div>
            <label htmlFor="email">Inserisci una email:</label>
            <input type="email"  className="form-control" name="email" id="email" placeholder="Email" autoComplete="on" value={formData.email} onChange={handleInputChange} />
          </div>
          <div>
            <label htmlFor="password">Inserisci una password:</label>
            <input type="password" className="form-control" name="password" id="password" autoComplete="off" value={formData.password} onChange={handleInputChange} />
          </div>
          <button type="submit" className="btn btn-primary btn-lg w-100 mt-3">Invio</button>
        </form>
        </div>
      );
  };
  
  export default SignInCliente;