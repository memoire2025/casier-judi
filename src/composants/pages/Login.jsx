import { useState } from "react";
import { useNavigate } from 'react-router-dom';
import api from "../../api/api";
import { Col, Form, Button, Alert } from "react-bootstrap";

export default function Login () {

    const [email, setEmail] = useState("");
    const [mdp, setmdp] = useState("");
    const [message, setMessage] = useState("");
    const navigate = useNavigate();
    const [loader, setLoader] = useState(false);

    const handleLogin = async (e) => {
        e.preventDefault();
        setLoader(true);
        setMessage('');

        try {
            
            const response = await api.post('/login', {email, mdp},{
                headers: { "Content-Type": "application/json" }
            });
            
            console.log(response.data.message);
            const { accessToken, code, poste, exp, nom } = response.data;

            if (response.data.status === 'success') {
                if (accessToken) {

                    const userInfo = {
                        code : code,
                        poste : poste,
                        exp : exp,
                        nom : nom,
                        accessToken : accessToken
                    };

                    localStorage.setItem("accessToken-casier", accessToken);
                    localStorage.setItem('userInfo-casier', JSON.stringify(userInfo));

                    navigate('/home');

                }
            } else {
                setMessage(response.data.message);
            }
        } catch (error) {
            setMessage(error.response?.data?.message || "Erreur lors de la connexion !");
        } finally {
            setLoader(false);
        }
    };

    return (
        <>
            <div className="login-page position-relative">
                <div className="d-flex justify-content-center align-items-center" style={{minHeight : '100vh'}}>

                    <div className="login-block"></div>
                    <div id="login-block" className="py-4 col-md-4 d-flex justify-content-center border position-relative">

                        <Form onSubmit={handleLogin} autoComplete="off" className="row justify-content-center col-12">
                            <div className="rounded-top col-md-12 my-2">
                                <h3 className="fw-bold text-uppercase text-primary text-center title-login" >Connexion</h3>
                                <hr />
                            </div>
                            <Form.Group as={Col} md='12' className="my-2">
                                <Form.Control type="text" autoComplete="off" className="form-control shadow-none rounded-2" placeholder="Nom d'utilisateur" value={email} onChange={(e) => setEmail(e.target.value)} required />
                            </Form.Group>
                            <Form.Group as={Col} md='12' className="my-2">
                                <Form.Control type="password" autoComplete="off" className="form-control shadow-none rounded-2" placeholder="Mot de passe" value={mdp} onChange={(e) => setmdp(e.target.value)} required />
                            </Form.Group>

                            <div className="form-check ms-4 col-md-12 my-2">
                                <input type="checkbox" id="check" className="form-check-input shadow-none" />
                                <label htmlFor="check" className="form-check-label text-secondary">Se souvenir de  moi</label>
                            </div>
                            <Form.Group as={Col} md='12' className="my-2">
                                <Button type="submit" variant="primary" disabled={loader} className="col-12 rounded-2 btn-submit">
                                    {
                                        loader ? <span className="spinner spinner-border" id="spinner"></span> : <span>Se connecter</span>
                                    } 
                                </Button>
                            </Form.Group>
                            
                            { message && <Alert variant="danger" className="col-11 rounded-0 p-1 my-2">{message}</Alert> }
                            
                        </Form>
                    </div>
                    
                </div>
            </div>
        </>
    )
}
