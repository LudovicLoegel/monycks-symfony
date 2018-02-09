<?php

namespace App\Controller\Admin;

use App\Entity\Skill;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SkillController extends Controller
{
    /**
     * @Route("/admin/skill/{id}/delete", name="skill_delete")
     */
    public function deleteSkillAction(Skill $skill)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($skill);
        $em->flush();

        return $this->redirectToRoute('admin');
    }

}
