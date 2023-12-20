import React, { Component } from 'react';
import { Carousel } from 'react-bootstrap'; // Assuming you are using react-bootstrap

class FormPrenotazione extends Component {
  constructor(props) {
    super(props);
    this.state = {
    };
  }

  render() {

    return (
        <div>
        <Carousel className="container-fluid my-5 p-auto w-75 border rounded" autoPlay={false} interval={null} controls={true} indicators={true}>
    
          <Carousel.Item>
            <h1 className="my-4 d-flex justify-content-center">REAL TIME UPDATE</h1>
                            <div className="m-5">
                            <label htmlFor="username">Modifica nome utente:</label>
                            <input type="text" className="form-control" name="username" id="username" placeholder="" autoComplete="on" defaultValue=""  />
                            </div>
                            <div className="m-5">
                            <label htmlFor="email">Modifica la email:</label>
                            <input type="email"  className="form-control" name="email" id="email" placeholder="" autoComplete="on" defaultValue="" />
                            </div>
                            <div  className="m-5">
                            <label htmlFor="password">Modifica la password:</label>
                            <input type="password" className="form-control" name="password" id="password" placeholder="" autoComplete="on" defaultValue="" />
                            </div>
          </Carousel.Item>
          <Carousel.Item>
            <h1 className="my-4 d-flex justify-content-center">REAL TIME UPDATE</h1>
                            <div className="m-5">
                            <label htmlFor="username">Modifica nome utente:</label>
                            <input type="text" className="form-control" name="username" id="username" placeholder="" autoComplete="on" defaultValue=""  />
                            </div>
                            <div className="m-5">
                            <label htmlFor="email">Modifica la email:</label>
                            <input type="email"  className="form-control" name="email" id="email" placeholder="" autoComplete="on" defaultValue="" />
                            </div>
                            <div  className="m-5">
                            <label htmlFor="password">Modifica la password:</label>
                            <input type="password" className="form-control" name="password" id="password" placeholder="" autoComplete="on" defaultValue="" />
                            </div>
          </Carousel.Item>
          </Carousel>
        </div>
      );
    }
}
    
export default FormPrenotazione;