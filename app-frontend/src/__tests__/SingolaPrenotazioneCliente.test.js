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
                <MemoryRouter initialEntries={['/dettagliprenotazionecliente/1']}>
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
                                id : '1234',
                                pietanza : '',
                                aggiunte : '',
                                rimozioni : '',
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

        expect(axiosClient.get).toHaveBeenCalledWith('/prenotazione_c/1');

        await waitFor ( () => {
            expect(screen.getByText('Da Luigi')).toBeInTheDocument();

        });
    });

});