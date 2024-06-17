import React from 'react';
import { render, screen, fireEvent, waitFor } from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import { MemoryRouter, Routes, Route } from 'react-router-dom';
import { ContextProvider, useStateContext } from '../contexts/ContextProvider';
import FormOrdinazione from '../views/FormOrdinazione';
import axiosClient from '../axios-client';
import { act } from 'react';

jest.mock('../axios-client');
jest.mock('../contexts/ContextProvider', () => {
    const originalModule = jest.requireActual('../contexts/ContextProvider');
    return {
        ...originalModule,
        useStateContext: jest.fn(),
    };
});

const renderWithContext = (component) => {
    act(() => {
        render(
            <ContextProvider>
                <MemoryRouter initialEntries={['/formordinazione/prenotazione_id/pietanza_id']}>
                    <Routes>
                        <Route path="/formordinazione/:prenotazione/:pietanza" element={component} />
                    </Routes>
                </MemoryRouter>
            </ContextProvider>
        );
    });
};

describe('FormOrdinazione', () => {
    const client_id = 'client_id';
    let mockUseStateContext;

    beforeEach(() => {
       
        mockUseStateContext = {
            profile: client_id,
            setNotification: jest.fn(),
            setNotificationStatus: jest.fn(),
        };
        useStateContext.mockReturnValue(mockUseStateContext);
    });

    afterEach(() => {
        jest.clearAllMocks();
    });

    it('Initial rendering goes well', async () => {
        //fetching delle possibili aggiunte di ingredienti
        const fetchingAggiunte = axiosClient.get.mockResolvedValueOnce({data :[
            {
            id : 1,
            nome : 'melanzane',
        },
        {
            id : 2,
            nome : 'ricotta',
        },
    ]});
        //fetching delle possibili rimozioni di ingredienti
        const fetchingRimozioni = axiosClient.get.mockResolvedValueOnce({data :[
            {
                id : 1,
                nome : 'pomodoro'
        },
        {   
            id : 2,
            nome : 'mozzarella'
        }
    ]});
        //questo non so perchè scrivere codice più chiaro è brutto
        const fetchingBoh = axiosClient.get.mockResolvedValueOnce({data :[
            {
                id : 'invito_id',
            }
        ]});
        //fetching dei dettagli delle pietanze
        const fetchingDettagli = axiosClient.get.mockResolvedValueOnce({data :
            {
            nome : 'Pizza margherita',
            ingredienti : 'Farina,pomodoro,mozzarella',
            allergeni : 'latticini,graminacee',
            }
});

        renderWithContext(<FormOrdinazione/>);
        
        expect(screen.getAllByText('Ordina')[0]).toBeInTheDocument();
        expect(fetchingAggiunte).toHaveBeenCalledWith('/get-possibili-aggiunte/pietanza_id');
        expect(fetchingRimozioni).toHaveBeenCalledWith('/get-possibili-rimozioni/pietanza_id');
        expect(fetchingBoh).toHaveBeenCalledWith('/get-invito-by-prenotazione-cliente/prenotazione_id/client_id');
        expect(fetchingDettagli).toHaveBeenCalledWith('/pietanza_dettagli/pietanza_id');
        expect(screen.getByText('quantità')).toBeInTheDocument();

        
    });

  /*  it('Order submission goes smoothly',async () => {
         //fetching delle possibili aggiunte di ingredienti
         const fetchingAggiunte = axiosClient.get.mockResolvedValueOnce({data :[
            {
            id : 1,
            nome : 'melanzane',
        },
        {
            id : 2,
            nome : 'ricotta',
        },
    ]});
        //fetching delle possibili rimozioni di ingredienti
        const fetchingRimozioni = axiosClient.get.mockResolvedValueOnce({data :[
            {
                id : 1,
                nome : 'pomodoro'
        },
        {   
            id : 2,
            nome : 'mozzarella'
        }
    ]});
        //questo non so perchè scrivere codice più chiaro è brutto
        const fetchingBoh = axiosClient.get.mockResolvedValueOnce({data :[
            {
                id : 'invito_id',
            }
        ]});
        //fetching dei dettagli delle pietanze
        const fetchingDettagli = axiosClient.get.mockResolvedValueOnce({data : 
            {
            nome : 'Pizza margherita',
            ingredienti : 'Farina,pomodoro,mozzarella',
            allergeni : 'latticini,graminacee',
            }
});     
        axiosClient.post.mockResolvedValueOnce({data:{}});

        renderWithContext(<FormOrdinazione/>);
        
        expect(screen.getAllByText('Ordina')[0]).toBeInTheDocument();
        expect(fetchingAggiunte).toHaveBeenCalledWith('/get-possibili-aggiunte/pietanza_id');
        expect(fetchingRimozioni).toHaveBeenCalledWith('/get-possibili-rimozioni/pietanza_id');
        expect(fetchingBoh).toHaveBeenCalledWith('/get-invito-by-prenotazione-cliente/prenotazione_id/client_id');
        expect(fetchingDettagli).toHaveBeenCalledWith('/pietanza_dettagli/pietanza_id');

        await waitFor(() => {
            expect(screen.getByText(/Pizza margherita/i)).toBeInTheDocument();
            expect(screen.getByText('quantità')).toBeInTheDocument();
        });

        act(() => {
         //   fireEvent.change(screen.getByText('mozzarella'));
         //   fireEvent.change(screen.getByText('melanzane'));
            fireEvent.click(screen.getByRole('button', { name: 'Ordina' }));
        });

        await waitFor( () => {
            expect(axiosClient.post).toHaveBeenCalledWith('/crea-ordinazione',{
            invito: 'invito_id',
            pietanza: 'pietanza_id',
            aggiunte: [],
            rimozioni: [],
          });
           expect(mockUseStateContext.setNotificationStatus).toHaveBeenCalledWith('success');
           expect(mockUseStateContext.setNotification).toHaveBeenCalledWith('Ordinazione creata con successo.');
        });
    }); */
    it('Order submission goes wrong', async () => {
         //fetching delle possibili aggiunte di ingredienti
         const fetchingAggiunte = axiosClient.get.mockResolvedValueOnce({data :[
            {
            id : 1,
            nome : 'melanzane',
        },
        {
            id : 2,
            nome : 'ricotta',
        },
    ]});
        //fetching delle possibili rimozioni di ingredienti
        const fetchingRimozioni = axiosClient.get.mockResolvedValueOnce({data :[
            {
                id : 1,
                nome : 'pomodoro'
        },
        {   
            id : 2,
            nome : 'mozzarella'
        }
    ]});
        //questo non so perchè scrivere codice più chiaro è brutto
        const fetchingBoh = axiosClient.get.mockResolvedValueOnce({data :[
            {
                id : 'invito_id',
            }
        ]});
        //fetching dei dettagli delle pietanze
        const fetchingDettagli = axiosClient.get.mockResolvedValueOnce({data : 
            {
            nome : 'Pizza margherita',
            ingredienti : 'Farina,pomodoro,mozzarella',
            allergeni : 'latticini,graminacee',
            }
});     
        axiosClient.post.mockRejectedValueOnce({data:{}});

        renderWithContext(<FormOrdinazione/>);
        
        expect(screen.getAllByText('Ordina')[0]).toBeInTheDocument();
        expect(fetchingAggiunte).toHaveBeenCalledWith('/get-possibili-aggiunte/pietanza_id');
        expect(fetchingRimozioni).toHaveBeenCalledWith('/get-possibili-rimozioni/pietanza_id');
        expect(fetchingBoh).toHaveBeenCalledWith('/get-invito-by-prenotazione-cliente/prenotazione_id/client_id');
        expect(fetchingDettagli).toHaveBeenCalledWith('/pietanza_dettagli/pietanza_id');

        await waitFor(() => {
            expect(screen.getByText(/Pizza margherita/i)).toBeInTheDocument();
        });

        act(() => {
         //   fireEvent.change(screen.getByText('mozzarella'));
         //   fireEvent.change(screen.getByText('melanzane'));
            fireEvent.click(screen.getByRole('button', { name: 'Ordina' }));
        });

        await waitFor( () => {
         /*   expect(axiosClient.post).toHaveBeenCalledWith('/crea-ordinazione',{
            invito: 'invito_id',
            pietanza: 'pietanza_id',
            aggiunte: [],
            rimozioni: [],
          }); */
           expect(mockUseStateContext.setNotificationStatus).toHaveBeenCalledWith('failure');
           expect(mockUseStateContext.setNotification).toHaveBeenCalledWith('Errore durante il salvataggio dell\'ordinazione.');
           expect(screen.getByText('Errore durante il salvataggio dell\'ordinazione.'));
        });
    });
});