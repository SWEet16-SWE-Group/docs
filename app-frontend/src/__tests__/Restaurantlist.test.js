import React from 'react';
import {render , screen , fireEvent , waitFor} from '@testing-library/react';
import { MemoryRouter , Routes , Route } from 'react-router-dom';
import RestaurantList from '../views/RestaurantList';
import fetchRestaurants from '../services/RestaurantService';
import { ContextProvider , useStateContext } from '../contexts/ContextProvider';
import {act} from 'react';
import '@testing-library/jest-dom';


jest.mock('../services/RestaurantService');
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
        <MemoryRouter>
            <RestaurantList/>
        </MemoryRouter>
        </ContextProvider>
    );
})
};

describe('RestaurantList', () => {

    let mockUseStateContext;

    beforeEach(() => {
        fetchRestaurants.mockReset();
        mockUseStateContext = {
            setNotification: jest.fn(),
            setNotificationStatus: jest.fn(),
        };
        useStateContext.mockReturnValue(mockUseStateContext);
    }
    );

    afterEach(() => {
        jest.clearAllMocks();
    });
    
    it('renders an empty list', async() => {
        fetchRestaurants.mockReturnValue(
            {
                listRistoranti : [

                ]
            }
        );
        renderWithContext(<RestaurantList />);

        expect(screen.getByText(/Loading/i)).toBeInTheDocument();

        await waitFor( () => {
            expect(screen.getByText(/Nessun ristorante corrisponde ai tuoi criteri di ricerca!/i));
        }
        );

    });

    it('handles API errors', async () => {
        
       fetchRestaurants.mockRejectedValue({
        response : {
        data : {
            status : 'failure',
            notification : 'Nessun ristorante presente nella città da te inserita',
        }
    }
       });

        renderWithContext(<RestaurantList />);

        await waitFor(() => {
            expect(mockUseStateContext.setNotificationStatus).toHaveBeenCalledWith('failure');
            expect(mockUseStateContext.setNotification).toHaveBeenCalledWith('Nessun ristorante presente nella città da te inserita');
        });
    });

    
      it('renders the retrieved list correctly', async () => {
        fetchRestaurants.mockReturnValue(
            {listaRistoranti : [
            {ristorante : 
            {
                nome : 'Da Todaro',
                orario : '20:00-22:30',
                indirizzo : 'Milano',
                cucina : {
                    Cucina : 'pesce'
                },
            }
        },
             {ristorante : 
            {
                nome : 'Da Luigi',
                orario : '19:30-22:30',
                indirizzo : 'Milano',
                cucina : {
                    Cucina : 'pizza'
                },
            }
        },
        ],
    }
);
        renderWithContext(<RestaurantList/>);
      //  act();

        expect(screen.getByText(/Loading/i)).toBeInTheDocument();

        await waitFor(() => {
            const oneOfManyPlaces = screen.getAllByText(/Milano/i);
            expect(screen.getByText(/Da Todaro/i)).toBeInTheDocument();
            expect(oneOfManyPlaces[0]).toBeInTheDocument();
            expect(screen.getByText(/Cucina : pesce/i)).toBeInTheDocument();
            expect(screen.getByText(/20:00-22:30/i)).toBeInTheDocument();
            expect(screen.getByText(/19:30-22:30/i)).toBeInTheDocument();
            expect(screen.getByText(/Da Luigi/i)).toBeInTheDocument();
            expect(screen.getByText(/Cucina : pizza/i)).toBeInTheDocument();


        });
    });
    
    it('filter:"carne" works correctly',async () => {
        fetchRestaurants.mockReturnValue({
            listaRistoranti : [
            {ristorante : 
            {
                nome : 'Da Todaro',
                orario : '20:00-22:30',
                indirizzo : 'Milano',
                cucina : {
                    Cucina : 'pesce'
                },
            }
        },
    ]
}
        );
        renderWithContext(<RestaurantList />);

        await waitFor( () => {
            expect(screen.getByText(/Da Todaro/i)).toBeInTheDocument();
        });

        const filterButton = screen.getByRole("carneFilter");
        fireEvent.click(filterButton);
        expect(screen.queryByText(/Da Todaro/i)).not.toBeInTheDocument();
    });

    it('filter:"orario" works correctly',async () => {
        fetchRestaurants.mockReturnValue({
            listaRistoranti : [
            {ristorante : 
            {
                nome : 'Da Todaro',
                orario : '20:00-22:30',
                indirizzo : 'Milano',
                cucina : {
                    Cucina : 'pesce'
                },
            }
        },
    ]
});
    renderWithContext(<RestaurantList />);

    await waitFor( () => {
        expect(screen.getByText(/Orario di apertura : 20:00-22:30/i)).toBeInTheDocument();
    });

    const hourButton = screen.getByRole("timeArrivalFilter");
    fireEvent.change(hourButton,{target: {value: '19:00'}});
    fireEvent.click(screen.getByText("Applica filtro"));
    expect(screen.queryByText(/Da Todaro/i)).not.toBeInTheDocument();

    }); 


    })
