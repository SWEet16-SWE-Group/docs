import React, { Component, useState } from 'react';
import axios from 'axios';

class ClientUpdate extends Component {
    state = {
      cliente: []
    }
    
    componentDidMount() {
      const url = 'http://localhost:8888/select_cliente.php'
      axios.get(url).then(response =>
        this.setState({ cliente: response.data }));
      }
       /*     
        const handleInputChange = (event) => {
          const { name, value } = event.target;
          setFormData({ ...formData, [name]: value });
        };
      
        const handleSubmit = (event) => {
          event.preventDefault();
      
          axios
            .post("http://localhost:8888/update_cliente.php", formData)
            .then((response) => {
              console.log(response);
            })
            .catch((error) => {
              console.log(error);
            });
        };*/
      
        render() 
        {
            return (
                <div className="container-fluid d-flex justify-content-center">
                   {this.state.cliente.map((rs, index) => (
                    <form key={index} className="form-group" /*onSubmit={handleSubmit}*/>
                        <h1 className="mt-4 d-flex justify-content-center">UPDATE</h1>
                            <input type="hidden" className="form-control" name="id_cliente" id="id_cliente" value={rs.Id_cliente} />
                            <div>
                            <label htmlFor="username">Modifica nome utente:</label>
                            <input type="text" className="form-control" name="username" id="username" placeholder={rs.Username} autoComplete="on" value={rs.Username} /*onChange={handleInputChange}*/ />
                            </div>
                            <div>
                            <label htmlFor="email">Modifica la email:</label>
                            <input type="email"  className="form-control" name="email" id="email" placeholder={rs.Email} autoComplete="on" value={rs.Email} /*onChange={handleInputChange}*/ />
                            </div>
                            <div>
                            <label htmlFor="password">Modifica la password:</label>
                            <input type="password" className="form-control" name="password" id="password" autoComplete="off" value={rs.Password} /*onChange={handleInputChange}*/ />
                            </div>

                        <button type="submit" className="btn btn-primary btn-lg w-100 mt-3">Invio</button>
                    </form>
                    ))}
                </div>
            );
          }
      }
      
export default ClientUpdate;