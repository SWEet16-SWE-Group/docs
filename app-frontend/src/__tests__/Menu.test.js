import React from 'react';
import { render, screen, fireEvent, waitFor } from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import { MemoryRouter, Routes, Route } from 'react-router-dom';
import Menu from '../views/Menu';
import axiosClient from '../axios-client';
import { act } from 'react';

jest.mock('../axios-client');

const renderInsideRouter = (component) => {
    act(() => {
        render(
                <MemoryRouter initialEntries={['/menu/ristorante_id/prenotazione_id']}>
                    <Routes>
                        <Route path="/menu/:ristorante/:prenotazione" element={component} />
                    </Routes>
                </MemoryRouter>
        );
    });
};

describe('RistoratoreDashboard', () => {

    beforeEach(() => {
        axiosClient.get.mockResolvedValue({
            data : [
                {
                    id : 1,
                    nome : 'pizza',
                    ingredienti : 'farina,mozzarella,pomodoro',
            }
        ]
        });
    });

    afterEach(() => {
        jest.clearAllMocks();
    });

    it('Initial render goes well',async () => {
        renderInsideRouter(<Menu/>);
        expect(axiosClient.get).toHaveBeenCalledWith('/menu/ristorante_id');

        await waitFor(() => {
            expect(screen.getByText('pizza')).toBeInTheDocument();
            expect(screen.getByText('farina,mozzarella,pomodoro')).toBeInTheDocument();
            expect(screen.getByText(/Ordina/i)).toBeInTheDocument();
            expect(screen.getByText(/Annulla/i)).toBeInTheDocument();
        });
    });
});