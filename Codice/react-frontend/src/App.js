import './App.css';

import Navbar from './components/navbar.js';
import SignInCliente from './components/new_cliente.js';
import UpdateCliente from './components/edit_cliente.js';
import RemoveCliente from './components/remove_cliente.js';
import FormPrenotazione from './components/carousel_prenotazione.js';

function App() {
  return (
    <>
    <Navbar />
    <SignInCliente />
    <UpdateCliente />
    <RemoveCliente />
    <FormPrenotazione />
    </>
  );
}

export default App;
