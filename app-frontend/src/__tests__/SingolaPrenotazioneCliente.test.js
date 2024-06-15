import React from 'react';
import { render, screen, fireEvent, waitFor } from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import { MemoryRouter, Routes, Route } from 'react-router-dom';
import { ContextProvider, useStateContext } from '../contexts/ContextProvider';
import ClientePrenotazione from '../views/SingolaPrenotazioneCliente';
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
                <MemoryRouter initialEntries={['/dettagliprenotazionecliente/prenotazione_id']}>
                    <Routes>
                        <Route path="/dettagliprenotazionecliente/:id" element={component} />
                    </Routes>
                </MemoryRouter>
            </ContextProvider>
        );
    });
};

describe('Single prenotation testing', () => {
    const ristoratoreId = '12345';
    let mockUseStateContext;

    beforeEach(() => {
        axiosClient.get.mockResolvedValue({
            data : {
                prenotazione : {
                    id : '123',
                    nome : 'Da Luigi',
                    stato : 'Accettata',
                    orario : "20:00",
                },
                ordinazioni : [
                        {
                            nome : 'Todaro',
                            ordinazioni : [{
                                id : 'ordinazione_id',
                                pietanza : 'Pizza margherita',
                                aggiunte : 'Acciughe',
                                rimozioni : 'Mozzarella',
                            }],
                        }
                    ],
                
            }
        });

        mockUseStateContext = {
            profile: ristoratoreId,
            setNotification: jest.fn(),
            setNotificationStatus: jest.fn(),
        };
        useStateContext.mockReturnValue(mockUseStateContext);
    });

    afterEach(() => {
        jest.clearAllMocks();
    });

    it('Fetching reservation data goes well',async () => {
        renderWithContext(<ClientePrenotazione/>);

        expect(axiosClient.get).toHaveBeenCalledWith('/prenotazione_c/prenotazione_id');

        await waitFor ( () => {
            expect(screen.getByText('Da Luigi')).toBeInTheDocument();
            expect(screen.getByText('Pizza margherita')).toBeInTheDocument();
            expect(screen.getByText('Acciughe')).toBeInTheDocument();
            expect(screen.getByText('Mozzarella')).toBeInTheDocument();
        });
    });

    it('Reservation deletion goes well',async () => {
        axiosClient.delete.mockResolvedValueOnce({data:{}});
        window.confirm = jest.fn().mockImplementation(() => true)

        renderWithContext(<ClientePrenotazione/>);

        expect(axiosClient.get).toHaveBeenCalledWith('/prenotazione_c/prenotazione_id');

        await waitFor ( () => {
            expect(screen.getByText('Da Luigi')).toBeInTheDocument();
        });

        act( () => {
            fireEvent.click(screen.getByText(/Annulla prenotazione/i));
        });

        await waitFor(() => {       
            expect(axiosClient.delete).toHaveBeenCalledWith('/prenotazione/prenotazione_id');
            expect(mockUseStateContext.setNotification).toHaveBeenCalledWith('Prenotazione annullata con successo.');
            expect(mockUseStateContext.setNotificationStatus).toHaveBeenCalledWith('success');
        });
    });

    it('Reservation deletion goes wrong',async () => {
        axiosClient.delete.mockRejectedValueOnce({data:{}});
        window.confirm = jest.fn().mockImplementation(() => true)

        renderWithContext(<ClientePrenotazione/>);

        expect(axiosClient.get).toHaveBeenCalledWith('/prenotazione_c/prenotazione_id');

        await waitFor ( () => {
            expect(screen.getByText('Da Luigi')).toBeInTheDocument();
        });

        act( () => {
            fireEvent.click(screen.getByText(/Annulla prenotazione/i));
        });

        await waitFor(() => {       
            expect(axiosClient.delete).toHaveBeenCalledWith('/prenotazione/prenotazione_id');
            expect(mockUseStateContext.setNotification).toHaveBeenCalledWith('Errore durante l\'eliminazione della prenotazione.');
            expect(mockUseStateContext.setNotificationStatus).toHaveBeenCalledWith('error');
        });
    });

    it('Order deletion goes well',async () => {
        axiosClient.delete.mockResolvedValueOnce({data:{}});
        window.confirm = jest.fn().mockImplementation(() => true)

        renderWithContext(<ClientePrenotazione/>);

        expect(axiosClient.get).toHaveBeenCalledWith('/prenotazione_c/prenotazione_id');

        await waitFor ( () => {
            expect(screen.getByText('Da Luigi')).toBeInTheDocument();
        });

        act( () => {
            fireEvent.click(screen.getByText(/Cancella/i));
        });

        await waitFor(() => {       
            expect(axiosClient.delete).toHaveBeenCalledWith('/ordinazione/ordinazione_id');
            expect(mockUseStateContext.setNotification).toHaveBeenCalledWith('Ordinazione eliminata con successo.');
            expect(mockUseStateContext.setNotificationStatus).toHaveBeenCalledWith('success');
        });
    });

    it('Order deletion goes wrong',async () => {
        axiosClient.delete.mockRejectedValueOnce({data:{}});
        window.confirm = jest.fn().mockImplementation(() => true)

        renderWithContext(<ClientePrenotazione/>);

        expect(axiosClient.get).toHaveBeenCalledWith('/prenotazione_c/prenotazione_id');

        await waitFor ( () => {
            expect(screen.getByText('Da Luigi')).toBeInTheDocument();
        });

        act( () => {
            fireEvent.click(screen.getByText(/Cancella/i));
        });

        await waitFor(() => {       
            expect(axiosClient.delete).toHaveBeenCalledWith('/ordinazione/ordinazione_id');
            expect(mockUseStateContext.setNotification).toHaveBeenCalledWith('Errore durante l\'eliminazione dell\'ordinazione.');
            expect(mockUseStateContext.setNotificationStatus).toHaveBeenCalledWith('error');
        });
    });
});