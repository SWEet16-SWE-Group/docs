import React from 'react';
import { render, screen , waitFor } from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import { MemoryRouter, Routes, Route } from 'react-router-dom';
import { ContextProvider, useStateContext } from '../contexts/ContextProvider';
import Ristoranti from '../views/Ristoranti';
import axiosClient from '../axios-client';
import { act } from 'react';

jest.mock('../axios-client');

const renderWithContext = (component) => {
    act(() => {
        render(
                <MemoryRouter initialEntries={['/dashboardcliente']}>
                    <Routes>
                        <Route path="/dashboardcliente" element={component} />
                    </Routes>
                </MemoryRouter>
        );
    });
};

describe('Testing restaurants', () => {

    afterEach(() => {
        jest.clearAllMocks();
    });

    it('Testing initial rendering e data fetching', async () => {
        axiosClient.get.mockResolvedValueOnce({
            data : {

            }
        })

        renderWithContext(<Ristoranti/>);
        expect(axiosClient.get).toHaveBeenCalledWith('/ristoranti');

        await waitFor( () => {
            expect(screen.getByText(/Nome/i)).toBeInTheDocument();
        });
    });
});