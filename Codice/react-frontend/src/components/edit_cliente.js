import React, { Component } from 'react';
import axios from 'axios';

class UpdateCliente extends Component {
  constructor() {
    super();
    this.state = {
      cliente : []
    }
  }
    
    componentDidMount() {  
      axios.get("http://localhost:8888/select_single_cliente.php").then(response => {
        this.setState({ cliente: response.data });
      });
      }
            
      handleInputChange = (event) => {
          
        const item = this.state.cliente[0].ID_cliente;
        const update = [
          {
          id_cliente : item,
          [event.target.name] : event.target.value
          }
        ]
        event.preventDefault();
    
        axios
          .post("http://localhost:8888/update_cliente.php", update[0])
      };
      
        render() 
        {
            return (
                <div className="container-fluid d-flex justify-content-center mb-5">
                   {this.state.cliente.map((rs, index) => (
                    <form key={index} className="form-group col-4" onSubmit={this.handleSubmit}>
                        <h1 className="mt-4 d-flex justify-content-center">REAL TIME UPDATE</h1>
                            <div>
                            <label htmlFor="username">Modifica nome utente:</label>
                            <input type="text" className="form-control" name="username" id="username" placeholder={rs.Username} autoComplete="on" defaultValue={rs.Username} onChange={this.handleInputChange} />
                            </div>
                            <div>
                            <label htmlFor="email">Modifica la email:</label>
                            <input type="email"  className="form-control" name="email" id="email" placeholder={rs.Email} autoComplete="on" defaultValue={rs.Email} onChange={this.handleInputChange} />
                            </div>
                            <div>
                            <label htmlFor="password">Modifica la password:</label>
                            <input type="password" className="form-control" name="password" id="password" placeholder={rs.Password} autoComplete="off" defaultValue={rs.Password} onChange={this.handleInputChange} />
                            </div>
                    </form>
                    ))}
                </div>
            );
          }
      }
      
export default UpdateCliente;
