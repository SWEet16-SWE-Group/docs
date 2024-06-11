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
                <MemoryRouter initialEntries={['/prenotazione_r/12345']}>
                    <Routes>
                        <Route path="/prenotazione_r/:id" element={component} />
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

        // Mock console.error
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
                        { id: 1, pietanza: 'Pasta', aggiunte: 'Cheese', rimozioni: 'Garlic' }
                    ]
                }
            ]
        };

        axiosClient.get.mockResolvedValueOnce({ data: prenotazioneData });

        renderWithContext(<RistoratorePrenotazione />);

        expect(screen.getByText('Caricamento...')).toBeInTheDocument();

        await waitFor(() => {
            expect(screen.getByText(/Test Prenotazione/i)).toBeInTheDocument();
            expect(screen.getByText(/In attesa/i)).toBeInTheDocument();
            expect(screen.getByText(/Pasta/i)).toBeInTheDocument();
        });
    });

    it('handles API errors when fetching data', async () => {
        const errorMessage = new Error('Api Error');
        axiosClient.get.mockRejectedValueOnce(errorMessage);

        renderWithContext(<RistoratorePrenotazione />);

        await waitFor(() => {
            expect(console.error).toHaveBeenCalledWith('Errore nel recupero della prenotazione:', errorMessage);
        });
    });

    it('accepts the prenotazione', async () => {
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
                        { id: 1, pietanza: 'Pasta', aggiunte: 'Cheese', rimozioni: 'Garlic' }
                    ]
                }
            ]
        };

        axiosClient.get.mockResolvedValueOnce({ data: prenotazioneData });
        axiosClient.put.mockResolvedValueOnce({ data: { stato: 'Accettata' } });

        renderWithContext(<RistoratorePrenotazione />);

        await waitFor(() => {
            expect(screen.getByText('Accetta')).toBeInTheDocument();
        });

        const acceptButton = screen.getByText('Accetta');
        fireEvent.click(acceptButton);

        await waitFor(() => {
            expect(axiosClient.put).toHaveBeenCalledWith(`/update-prenotazioni/${prenotazioneId}`, { stato: 'Accettata' });
            expect(mockUseStateContext.setNotificationStatus).toHaveBeenCalledWith('success');
            expect(mockUseStateContext.setNotification).toHaveBeenCalledWith('Prenotazione accettata con successo.');
        });
    });

    it('refuses the prenotazione', async () => {
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
                        { id: 1, pietanza: 'Pasta', aggiunte: 'Cheese', rimozioni: 'Garlic' }
                    ]
                }
            ]
        };

        axiosClient.get.mockResolvedValueOnce({ data: prenotazioneData });
        axiosClient.put.mockResolvedValueOnce({ data: { stato: 'Rifiutata' } });

        renderWithContext(<RistoratorePrenotazione />);

        await waitFor(() => {
            expect(screen.getByText('Rifiuta')).toBeInTheDocument();
        });

        const refuseButton = screen.getByText('Rifiuta');
        fireEvent.click(refuseButton);

        await waitFor(() => {
            expect(axiosClient.put).toHaveBeenCalledWith(`/update-prenotazioni/${prenotazioneId}`, { stato: 'Rifiutata' });
            expect(mockUseStateContext.setNotificationStatus).toHaveBeenCalledWith('success');
            expect(mockUseStateContext.setNotification).toHaveBeenCalledWith('Prenotazione rifiutata con successo.');
        });
    });
});
