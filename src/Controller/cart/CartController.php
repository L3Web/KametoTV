<?php

namespace App\Controller\cart;


use App\Controller\Controller;
use App\Entity\Commande;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class CartController extends Controller
{

    private SessionInterface $session;
    private ProductRepository $productRepository;

    #[Pure] public function __construct(EntityManagerInterface $entityManager, RequestStack $requestStack, ProductRepository $productRepository)
    {
        parent::__construct($entityManager);
        $this->session = $requestStack->getSession();
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/{_locale<%app.supported_locales%>}/panier", name="app_cart")
     */
    public function cart()
    {
        $cart = $this->session->get('panier');
        $cartData = [];
        if ($cart !== null) {
            foreach ($cart as $id => $quantity) {
                $cartData [] = [
                    'product' => $this->productRepository->find($id),
                    'quantity' => $quantity
                ];
            }
        }
        $total = $this->session->get("total");

        return $this->render('cart/cart.html.twig', [
            'items' => $cartData,
            'total' => $total
        ]);
    }

    /**
     * @Route("/panier/add/{id<^[1-9]{1}[0-9]*$>}", name="app_cart_add")
     */
    public function add(int $id)
    {
        $cart = $this->session->get('panier');

        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }
        $this->session->set('panier', $cart);
        $product = $this->productRepository->findOneBy(array("id" => $id));
        $this->changePrice("+", $product->getPrice());

        return $this->redirectToRoute('app_boutique');
    }

    /**
     * @Route("/panier/remove/{id<^[1-9]{1}[0-9]*$>}", name="app_cart_remove")
     */
    public function remove(int $id)
    {
        $cart = $this->session->get('panier');

        if (!empty($cart[$id])) {
            unset($cart[$id]);
        }
        $this->session->set('panier', $cart);
        $product = $this->productRepository->findOneBy(array("id" => $id));
        $this->changePrice("-", $product->getPrice());

        return $this->redirectToRoute("app_cart");
    }


    /**
     * @Route("/account/commander", name="app_commander")
     *
     */
    public function commander(UserRepository $userRepository, UserInterface $user): Response
    {
        $cart = $this->session->get("panier");
        $commande = new Commande();
        $commande->setArticles($cart);
        $commande->setDate(new \DateTimeImmutable("now"));
        $commande->setTotal($this->session->get("total"));
        $commande->setIdUser($userRepository->findOneBy(array("id" => $user->getId())));
        $commande->setStatus(0);

        $this->entityManager->persist($commande);
        $this->entityManager->flush();

        $this->session->set("panier", []);
        $this->session->set("total", 0);

        return $this->redirectToRoute('app_base_home');
    }


    private function changePrice(string $type, int $value): void
    {
        if ($type === "+") {
            $this->session->set('total', $this->session->get("total") + $value);
        } else {
            $this->session->set('total', $this->session->get("total") - $value);
        }
    }
}