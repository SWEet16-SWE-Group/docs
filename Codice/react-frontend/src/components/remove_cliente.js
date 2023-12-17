import React, { Component } from 'react';
import axios from 'axios';

class RemoveCliente extends Component {
  constructor() {
    super();
    this.state = {
      cliente : []
    }
  }
    
    componentDidMount() {  
      axios.get("http://localhost:8888/select_multiple_cliente.php").then(response => {
        this.setState({ cliente: response.data });
      });
      }
            
      handleDelete = (id) => (event) => {

        console.log(id);

        const item = this.state.cliente[id].ID_cliente;
        const remove = [
          {
          id_cliente : item,
          }
        ]
        event.preventDefault();
    
        axios
          .post("http://localhost:8888/delete_cliente.php", remove[0]);

        const updatedrows = this.state.cliente.filter(cliente => cliente[id] !== id);
        this.setState({ cliente : updatedrows})
      };
      
      render() {
        return (
            <div className="container-fluid my-5 pt-5">
             <div className="col-xs-8">
             <h1 className="d-flex justify-content-center">SELECT AND DELETE</h1>
             <table className="table table-striped">
               <thead className="thead-light">
                <tr>
                 <th>ID</th>
                 <th>Username</th>
                 <th>Email</th>
                 <th>Password</th>
                 <th></th>
                </tr>
               </thead>
               <tbody>
               {this.state.cliente.map((rs, index) => (
                 <tr key={index}>
                   <td>{rs.ID_cliente}</td>
                   <td>{rs.Username}</td>
                   <td>{rs.Email}</td>
                   <td>{rs.Password}</td>
                   <td>
                    <form className="form-group col-4" onSubmit={this.handleDelete(index)}>
                        <button type="submit" className="btn btn-outline-danger w-100">Elimina</button>
                    </form>
                   </td>
                 </tr>
                 ))}
               </tbody>
             </table>
             </div>
            </div>
         );
       }
     }

export default RemoveCliente;