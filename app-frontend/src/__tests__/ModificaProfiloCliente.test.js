import React , {act} from 'react';
import axiosClient from '../axios-client';
import { ContextProvider , useStateContext} from '../contexts/ContextProvider';
import ModificaProfiloCliente from '../views/ModificaProfiloCliente';
import '@testing-library/jest-dom/extend-expect';
import { render, screen, fireEvent, waitFor } from '@testing-library/react';
import { MemoryRouter ,Routes , Route } from 'react-router-dom';

jest.mock('../axios-client');
jest.mock('../contexts/ContextProvider', () => {
    const originalModule = jest.requireActual('../contexts/ContextProvider');
    return {
        ...originalModule,
        useStateContext: jest.fn(),
    };
});

const renderWithContext = (component) => {
    return render(
      <ContextProvider>
        <MemoryRouter initialEntries={['/modificaprofilocliente/1']}>
            <Routes>
                <Route path="/modificaprofilocliente/:id" element={component} />
            </Routes>
        </MemoryRouter>
      </ContextProvider>
    );
};

describe('ModificaProfiloCliente', () => {

    let mockUseStateContext;
    const client_id = "1";

    beforeEach( () => {
        axiosClient.get.mockResolvedValueOnce({
            data : {
                nome : 'Tullio'
            }
        }
        );
        localStorage.setItem('USER_ID',1);
        mockUseStateContext = {
            role: 'CLIENT',
            setNotification: jest.fn(),
            setNotificationStatus: jest.fn(),
        };
        useStateContext.mockReturnValue(mockUseStateContext);
    });

    it('Form correctly rendered',async () => {

        renderWithContext(<ModificaProfiloCliente/>);

        await waitFor(() => {
            expect(screen.getByText('Modifica le informazioni relative a questo profilo')).toBeInTheDocument();
            expect(screen.getByLabelText('Username')).toBeInTheDocument();
            expect(screen.getByRole('nameChanger',{'value': 'Tullio'})).toBeInTheDocument();
            expect(screen.getByText('Conferma modifiche')).toBeInTheDocument();
            expect(screen.getByText('Annulla')).toBeInTheDocument();
        });
    });

        it('Changed username rendered correctly',async () => {
            renderWithContext(<ModificaProfiloCliente/>);

            await waitFor ( () => {
            expect(screen.getByRole('nameChanger',{'value': 'Tullio'})).toBeInTheDocument();
            });

            act(() => {
                fireEvent.change(screen.getByLabelText('Username'), { target: { value: 'Tullio 2:la vendetta' } });
            });

            expect(screen.getByRole('nameChanger',{'value': 'Tullio 2:la vendetta'})).toBeInTheDocument();
        });

        it('Form submission handled successfully',async () => {

            axiosClient.put.mockResolvedValueOnce({ data: { status: 'success', notification: 'Dati aggiornati con successo.' } });

            renderWithContext(<ModificaProfiloCliente />);
    
            await waitFor(() => {
                expect(screen.getByLabelText('Username').value).toBe('Tullio');
            });

            act(() => {
              fireEvent.change(screen.getByLabelText('Username'), { target: { value: 'Tullio 2:la vendetta' } });
              fireEvent.click(screen.getByText('Conferma modifiche'));
            });
    
            await waitFor(() => {
                expect(axiosClient.put).toHaveBeenCalledWith('/client', {
                  //  user: localStorage.getItem('USER_ID'),
                    id: client_id,
                    user:localStorage.getItem('USER_ID'),
                    nome: 'Tullio 2:la vendetta',
                    role: 'CLIENT',
                });
            });
        });

        it('Form submission goes wrong',async () => {
            axiosClient.put.mockRejectedValueOnce({ response: { data: { errors: { error : [ "Errore nell'aggiornamento del cliente!"]}
         } } } );
    
            renderWithContext(<ModificaProfiloCliente />);
    
            await waitFor(() => {
                expect(screen.getByRole('nameChanger',{'value': 'Tullio'})).toBeInTheDocument();
            });
    
            act(() => {
              fireEvent.change(screen.getByLabelText('Username'), { target: { value: 'Tullio 2:il tuo nome non verrà salvato' } });
              fireEvent.click(screen.getByText('Conferma modifiche'));
            });
    
            await waitFor(() => {
                expect(screen.getByText('Errore nell\'aggiornamento del cliente!')).toBeInTheDocument();
            });
        });

        
    });

