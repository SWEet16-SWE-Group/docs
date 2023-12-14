import React, { Component } from 'react';
import axios from 'axios';

class ClientUpdate extends Component {
  constructor() {
    super();
    this.state = {
      id_cliente:"",
      username: "",
      email: "",
      password: "",
      cliente : []
    }
  }
    
    componentDidMount() {
      const url = 'http://localhost:8888/select_cliente.php'
      axios.get(url).then(response =>
        this.setState({ cliente: response.data }));
      }
            
        handleInputChange = (event) => {
         this.setState({ [event.target.name]: event.target.value });
        };
      
        handleSubmit = (event) => {
          event.preventDefault();
          const { id_cliente, username, password, email } = this.state;
      
          axios
            .post("http://localhost:8888/update_cliente.php", { id_cliente, username, password, email })
            .then((response) => {
              console.log(response);
            })
            .catch((error) => {
              console.log(error);
            });
        };
      
        render() 
        {
          const { id_cliente, username, password, email } = this.state;
            return (
                <div className="container-fluid d-flex justify-content-center">
                   {this.state.cliente.map((rs, index) => (
                    <form key={index} className="form-group" onSubmit={this.handleSubmit}>
                        <h1 className="mt-4 d-flex justify-content-center">UPDATE</h1>
                            <input type="hidden" className="form-control" name="id_cliente" id="id_cliente" value={id_cliente} />
                            <div>
                            <label htmlFor="username">Modifica nome utente:</label>
                            <input type="text" className="form-control" name="username" id="username" placeholder={rs.Username} autoComplete="on" value={username} onChange={this.handleInputChange} />
                            </div>
                            <div>
                            <label htmlFor="email">Modifica la email:</label>
                            <input type="email"  className="form-control" name="email" id="email" placeholder={rs.Email} autoComplete="on" value={email} onChange={this.handleInputChange} />
                            </div>
                            <div>
                            <label htmlFor="password">Modifica la password:</label>
                            <input type="password" className="form-control" name="password" id="password" placeholder={rs.Password} autoComplete="off" value={password} onChange={this.handleInputChange} />
                            </div>

                        <button type="submit" className="btn btn-primary btn-lg w-100 mt-3">Invio</button>
                    </form>
                    ))}
                </div>
            );
          }
      }
      
export default ClientUpdate;