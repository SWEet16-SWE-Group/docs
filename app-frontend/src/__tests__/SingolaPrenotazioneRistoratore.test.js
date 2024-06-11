import React from 'react';
import { render, screen, fireEvent, waitFor } from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import { MemoryRouter, Routes, Route } from 'react-router-dom';
import { ContextProvider, useStateContext } from '../contexts/ContextProvider';
import RistoratorePrenotazione from '../views/SingolaPrenotazioneRistoratore';
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
                <MemoryRouter initialEntries={['/dettagliprenotazioneristoratore/12345']}>
                    <Routes>
                        <Route path="/dettagliprenotazioneristoratore/:id" element={component} />
                    </Routes>
                </MemoryRouter>
            </ContextProvider>
        );
    });
};

describe('RistoratorePrenotazione', () => {
    const prenotazioneId = '12345';
    let mockUseStateContext;

    beforeEach(() => {
        axiosClient.get.mockReset();
        axiosClient.put.mockReset();

        mockUseStateContext = {
            setNotification: jest.fn(),
            setNotificationStatus: jest.fn(),
        };

        useStateContext.mockReturnValue(mockUseStateContext);
        
        jest.spyOn(console, 'error').mockImplementation(() => {});
    });

    afterEach(() => {
        jest.clearAllMocks();
    });

    it('renders and loads data correctly', async () => {
        const prenotazioneData = {
            prenotazione: {
                id: prenotazioneId,
                nome: 'Test Prenotazione',
                stato: 'In attesa',
                orario: '2023-06-07T10:00:00Z'
            },
            ordinazioni: [
                {
                    nome: 'Test Menu',
                    ordinazioni: [
                        { id: 1, pietanza: 'Pasta', ingredienti: 'Pomodoro', aggiunte: 'Formaggio', rimozioni: 'Aglio' }
                    ]
                }
            ]
        };

        const ingredientiData = [
            { ingrediente: 'Pomodoro', quantita: '1' },
            { ingrediente: 'Formaggio', quantita: '2' },
            { ingrediente: 'Aglio', quantita: '3' }
        ];

        axiosClient.get
            .mockResolvedValueOnce({ data: prenotazioneData })
            .mockResolvedValueOnce({ data: ingredientiData });

        renderWithContext(<RistoratorePrenotazione />);

        expect(screen.getByText('Caricamento...')).toBeInTheDocument();

        await waitFor(() => {
            expect(screen.getByText('Test Prenotazione'));
            expect(screen.getByText(/In attesa/i)).toBeInTheDocument();
            expect(screen.getByText('Pasta')).toBeInTheDocument();
        });
    });

    it('handles API errors when fetching prenotazione data', async () => {
        const errorMessage = new Error('API Error');
        axiosClient.get.mockRejectedValueOnce(errorMessage);

        renderWithContext(<RistoratorePrenotazione />);

        await waitFor(() => {
            expect(console.error).toHaveBeenCalledWith('Errore nel recupero della prenotazione:', errorMessage);
        });
    });

    it('handles API errors when fetching ingredienti data', async () => {
        const prenotazioneData = {
            prenotazione: {
                id: prenotazioneId,
                nome: 'Test Prenotazione',
                stato: 'In attesa',
                orario: '2023-06-07T10:00:00Z'
            },
            ordinazioni: [
                {
                    nome: 'Test Menu',
                    ordinazioni: [
                        { id: 1, pietanza: 'Pasta', ingredienti: 'Pomodoro', aggiunte: 'Formaggio', rimozioni: 'Aglio' }
                    ]
                }
            ]
        };

        const errorMessage = new Error('API Error');
        axiosClient.get
            .mockResolvedValueOnce({ data: prenotazioneData })
            .mockRejectedValueOnce(errorMessage);

        renderWithContext(<RistoratorePrenotazione />);

        await waitFor(() => {
            expect(console.error).toHaveBeenCalledWith('Errore nel recupero degli ingredienti:', errorMessage);
        });
    });

    it('handles accept button click', async () => {
        const prenotazioneData = {
            prenotazione: {
                id: prenotazioneId,
                nome: 'Test Prenotazione',
                stato: 'In attesa',
                orario: '2023-06-07T10:00:00Z'
            },
            ordinazioni: [
                {
                    nome: 'Test Menu',
                    ordinazioni: [
                        { id: 1, pietanza: 'Pasta', ingredienti: 'Pomodoro', aggiunte: 'Formaggio', rimozioni: 'Aglio' }
                    ]
                }
            ]
        };

        const ingredientiData = [
            { ingrediente: 'Pomodoro', quantita: '1' },
            { ingrediente: 'Formaggio', quantita: '2' },
            { ingrediente: 'Aglio', quantita: '3' }
        ];

        axiosClient.get
            .mockResolvedValueOnce({ data: prenotazioneData }) 
            .mockResolvedValueOnce({ data: ingredientiData });

        axiosClient.put.mockResolvedValueOnce({ data: { stato: 'Accettata' } });

        renderWithContext(<RistoratorePrenotazione />);

        await waitFor(() => {
            expect(screen.getByText(/Test Prenotazione/i)).toBeInTheDocument();
        });

        fireEvent.click(screen.getByText(/Accetta/i));

        await waitFor(() => {
            expect(mockUseStateContext.setNotificationStatus).toHaveBeenCalledWith('success');
            expect(mockUseStateContext.setNotification).toHaveBeenCalledWith('Prenotazione accettata con successo.');
        });
    });

    it('handles refuse button click', async () => {
        const prenotazioneData = {
            prenotazione: {
                id: prenotazioneId,
                nome: 'Test Prenotazione',
                stato: 'In attesa',
                orario: '2023-06-07T10:00:00Z'
            },
            ordinazioni: [
                {
                    nome: 'Test Menu',
                    ordinazioni: [
                        { id: 1, pietanza: 'Pasta', ingredienti: 'Pomodoro', aggiunte: 'Formaggio', rimozioni: 'Aglio' }
                    ]
                }
            ]
        };

        const ingredientiData = [
            { ingrediente: 'Pomodoro', quantita: '1' },
            { ingrediente: 'Formaggio', quantita: '2' },
            { ingrediente: 'Aglio', quantita: '3' }
        ];

        axiosClient.get
            .mockResolvedValueOnce({ data: prenotazioneData })
            .mockResolvedValueOnce({ data: ingredientiData });

        axiosClient.put.mockResolvedValueOnce({ data: { stato: 'Rifiutata' } });

        renderWithContext(<RistoratorePrenotazione />);

        await waitFor(() => {
            expect(screen.getByText(/Test Prenotazione/i)).toBeInTheDocument();
        });

        fireEvent.click(screen.getByText(/Rifiuta/i));

        await waitFor(() => {
            expect(mockUseStateContext.setNotificationStatus).toHaveBeenCalledWith('success');
            expect(mockUseStateContext.setNotification).toHaveBeenCalledWith('Prenotazione rifiutata con successo.');
        });
    });
});
